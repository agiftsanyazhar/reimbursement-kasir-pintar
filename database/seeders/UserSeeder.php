<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            ['nip' => '1234', 'name' => 'Doni', 'position' => 'Direktur', 'password' => Hash::make('123456')],
            ['nip' => '1235', 'name' => 'Dono', 'position' => 'Finance', 'password' => Hash::make('123456')],
            ['nip' => '1236', 'name' => 'Dana', 'position' => 'Staff', 'password' => Hash::make('123456')],
        ];

        foreach ($user as $item) {
            User::create($item);
        }
    }
}
