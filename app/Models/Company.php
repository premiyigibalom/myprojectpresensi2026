<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Testing\Fluent\Concerns\Has;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'radius',
        'word_start_time',
        'word_end_time',
    ];
    // fungsi untuk memastikan type data
    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'radius' => 'integer',
            'word_start_time' => 'datetime:H:i',
            'word_end_time' => 'datetime:H:i'
        ];
    }

    public static function getCompany(): ?self
    {
        return self::first();
    }
}
