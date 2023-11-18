<?php

namespace Database\Seeders;

use App\Models\Lottery_game;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        User::factory(100)->create();
        Lottery_game::factory(10)->create();
        User::create([
            "first_name"=>"Asror",
            "last_name"=>"Tukhtamishov",
            "email"=>"asror.96@examplemail.com",
            "password"=>Hash::make("jonik1996"),
            "is_admin"=>true
        ]);
    }
}
