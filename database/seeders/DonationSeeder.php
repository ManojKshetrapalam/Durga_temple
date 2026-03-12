<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Donation::create(['name' => 'Rajesh Sharma', 'amount' => 500.00, 'date' => '2023-10-24', 'method' => 'UPI', 'status' => 'Completed']);
        \App\Models\Donation::create(['name' => 'Anita Patel', 'amount' => 1200.00, 'date' => '2023-10-23', 'method' => 'Bank Transfer', 'status' => 'Completed']);
        \App\Models\Donation::create(['name' => 'Vikram Kumar', 'amount' => 250.00, 'date' => '2023-10-22', 'method' => 'Credit Card', 'status' => 'Pending']);
        \App\Models\Donation::create(['name' => 'Sanjay Krishnan', 'amount' => 5000.00, 'date' => '2023-10-21', 'method' => 'Cheque', 'status' => 'Completed']);
    }
}
