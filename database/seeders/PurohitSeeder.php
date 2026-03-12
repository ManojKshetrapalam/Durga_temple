<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurohitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Purohit::create([
            'name' => 'Rajesh Sharma',
            'phone' => '+91 98765 43210',
            'email' => 'rajesh@temple.org',
            'specialization' => 'Vedic Rituals, Homa',
            'experience' => 15
        ]);
        \App\Models\Purohit::create([
            'name' => 'Om Prakash',
            'phone' => '+91 87654 32109',
            'email' => 'omprakash@temple.org',
            'specialization' => 'Daily Aarti, Shanti Puja',
            'experience' => 20
        ]);
        \App\Models\Purohit::create([
            'name' => 'Vinod Kumar',
            'phone' => '+91 76543 21098',
            'email' => 'vinod@temple.org',
            'specialization' => 'Astrology, Marriage Rituals',
            'experience' => 12
        ]);
    }
}
