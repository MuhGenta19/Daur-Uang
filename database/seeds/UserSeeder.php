<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'name' => 'Admin',
            'email' => 'admin@dauruang.com',
            'password'  => Hash::make('password'),
            'phone_number'  => '0812345678',
            'address'  => 'Pondok Programmer Kec. Kretek Bantul Yogyakarta',
            'role_id'   => 5
        ]);

        User::create([
            'name' => 'Bendahara',
            'email' => 'bendahara@dauruang.com',
            'password'  => Hash::make('password'),
            'phone_number'  => '08999981907',
            'address'  => 'Pondok Programmer Kec. Kretek Bantul Yogyakarta',
            'role_id'   => 4
        ]);

        User::create([
            'name' => 'pengurus2',
            'email' => 'pengurus2@dauruang.com',
            'password'  => Hash::make('password'),
            'phone_number'  => '08167145678',
            'address'  => 'Pondok Programmer Kec. Kretek Bantul Yogyakarta',
            'role_id'   => 3
        ]);

        User::create([
            'name' => 'pengurus1',
            'email' => 'pengurus1@dauruang.com',
            'password'  => Hash::make('password'),
            'phone_number'  => '08123478161',
            'address'  => 'Pondok Programmer Kec. Kretek Bantul Yogyakarta',
            'role_id'   => 2
        ]);

        User::create([
            'name' => 'genta',
            'email' => 'muhammadgentaalam@gmail.com',
            'password'  => Hash::make('password'),
            'phone_number'  => '081295404679',
            'role_id'   => 1
        ]);
    }
}
