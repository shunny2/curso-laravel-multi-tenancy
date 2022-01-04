<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class TenantsTableSeeder extends Seeder
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
            'name' => 'Default User',
            'email' => 'default.user@gmail.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
