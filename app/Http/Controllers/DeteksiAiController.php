<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DeteksiAiController extends Controller
{
    /**
     * Menampilkan halaman utama Deteksi Penyakit AI.
     */
    public function index()
    {
        return view('deteksi-ai');
    }

    /**
     * Memproses foto sampel dan analisis via API Gemini Vision.
     */
    public function proses(Request $request)
    {
        // 1. Validasi Input Gambar & Teks Pertanyaan
        $request->validate([
            'foto_daun'  => 'required|image|mimes:jpeg,png,jpg,webp|max:15360',
            'pertanyaan' => 'nullable|string|max:500',
        ], [
            'foto_daun.required' => 'Silakan pilih atau unggah foto sampel terlebih dahulu.',
            'foto_daun.image'    => 'File yang diunggah harus berupa gambar.',
            'foto_daun.mimes'    => 'Format gambar harus JPEG, PNG, JPG, atau WEBP.',
            'foto_daun.max'      => 'Ukuran foto maksimal adalah 15MB.',
        ]);

        // 2. Ambil teks instruksi user
        $instruksiUser =$request->input('pertanyaan') 
            ? trim($request->input('pertanyaan')) 
            : 'Tolong analisis kondisi tanaman pada foto ini.';

        // 3. Simpan File Gambar ke Storage
        if ($request->hasFile('foto_daun')) {
            $file =$request->file('foto_daun');
            
            $path =$file->store('deteksi-ai', 'public');
            $url  = asset('storage/' .$path);

            $fileInfo = [
                'nama' => $file->getClientOriginalName(),
                'url'  => $url,
                'path' => $path,
            ];

            // 4. Konversi Gambar ke Base64 untuk dikirim ke API Gemini
            $imageBase64 = base64_encode(file_get_contents($file->getRealPath()));
            $mimeType    =$file->getMimeType();

            // 5. Prompt Sistem untuk Memaksa AI Mengirimkan Response JSON Valid
            $systemPrompt = "Anda adalah pakar agronomis dari SmartFarm. Analisis gambar yang dikirim.\n"
                . "Jika BUKAN tanaman, daun, atau buah, setel 'bukan_tanaman': true.\n"
                . "Jika ADALAH tanaman/buah/daun, analisis penyakit atau kondisinya secara rinci.\n"
                . "BALAS HANYA DENGAN FORMAT JSON VALID TANPA MARKDOWN ```json ```:\n"
                . "{\n"
                . '  "bukan_tanaman": false,' . "\n"
                . '  "nama_penyakit": "Nama Penyakit atau Tanaman Sehat",' . "\n"
                . '  "nama_latin": "Nama Latin Organisme / Tanaman",' . "\n"
                . '  "gejala": "Penjelasan rinci gejala visual yang terlihat pada gambar",' . "\n"
                . '  "penyebab": "Penyebab utama kondisi tersebut",' . "\n"
                . '  "pesan_bebas": "Pesan penjelas jika objek bukan tanaman",' . "\n"
                . '  "rekomendasi": [' . "\n"
                . '    {"judul": "Langkah 1", "deskripsi": "Detail penanganan"}' . "\n"
                . "  ]\n"
                . "}";

            $apiKey = config('services.gemini.key', env('GEMINI_API_KEY'));

            try {
                // Panggil Gemini 1.5 Flash Vision API (withoutVerifying bypass cURL SSL Laragon)
                $response = Http::withoutVerifying()->withHeaders([                     'Content-Type' => 'application/json',                 ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-3.1-flash-lite:generateContent?key={$apiKey}", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $systemPrompt . "\n\nInstruksi Pengguna: " . $instruksiUser],
                                [
                                    'inline_data' => [
                                        'mime_type' => $mimeType,
                                        'data'      => $imageBase64,
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]);

                if ($response->successful()) {
                    $jsonText =$response->json('candidates.0.content.parts.0.text');
                    
                    // Bersihkan tag markdown (```json / ```) jika AI memuatnya
                    $jsonText = preg_replace('/```(?:json)?/i', '', $jsonText);
                    $jsonText = trim($jsonText, " \t\n\r\0\x0B`");

                    $dataDiagnosis = json_decode($jsonText, true);

                    if (!$dataDiagnosis) {
                        $dataDiagnosis = [
                            'bukan_tanaman' => true,
                            'pesan_bebas'   => $jsonText ?: 'Gagal memproses struktur respon dari AI.'
                        ];
                    }
                } else {
                    $errorBody = $response->body();
                    Log::error('Gemini API Error Detail: ' . $errorBody);

                    $dataDiagnosis = [
                        'bukan_tanaman' => true,
                        'pesan_bebas'   => 'Error Google (' . $response->status() . '): ' . $errorBody
                    ];
                }

            } catch (\Exception $e) {
                Log::error('Exception Deteksi AI: ' . $e->getMessage());
                $dataDiagnosis = [
                    'bukan_tanaman' => true,
                    'pesan_bebas'   => 'Terjadi kesalahan sistem: ' . $e->getMessage()
                ];
            }

            // 6. Kembalikan Tampilan Blade dengan Data Hasil Analisis
            return view('deteksi-ai', compact('dataDiagnosis', 'fileInfo', 'instruksiUser'));
        }

        return redirect()->back()->with('error', 'Gagal mengunggah foto sampel.');
    }
}