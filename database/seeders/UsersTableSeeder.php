<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Criando um novo usuário.
        User::create([
            'name' => 'Cleiton Rasta',
            'email' => 'dj.rasta.cleiton@gmail.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
