<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmMetric extends Model
{
    use HasFactory;

    protected $table = 'farm_metrics';

    protected $fillable = [
        'day',
        'actual',
        'target',
    ];
}