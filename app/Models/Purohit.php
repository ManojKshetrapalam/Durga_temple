<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purohit extends Model
{
    use HasFactory;

    protected $table = 'purohits';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'specialization',
        'experience',
        'photo',
    ];

    public $timestamps = false; // Existing table has joined_at but not standard timestamps
}
