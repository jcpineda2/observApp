<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'dtic@senatur.gov.py'],
            [
                'name' => 'Admin',
                'password' => Hash::make('p4ssWord'),
            ]
        );

        $user->assignRole('Admin');
    }
}
