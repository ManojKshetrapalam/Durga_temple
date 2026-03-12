<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Donation extends Model
{
    /** @use HasFactory<\Database\Factories\DonationFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'date',
        'method',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
