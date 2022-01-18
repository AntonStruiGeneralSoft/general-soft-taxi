<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Classes\RoleEnum;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'firstName' => 'root',
            'lastName' => 'root',
            'role' => RoleEnum::ADMIN,
            'email' => 'q2wl1bdk31@thejoker5.com',
            'email_verified_at' => now(),
            'password' => Hash::make('qwe123'), 
            'remember_token' => Str::random(10),
        ]);
        User::factory(100)->create();
    }
}
