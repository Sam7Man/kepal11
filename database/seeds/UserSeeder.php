<?php

use Illuminate\Database\Seeder;
use App\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['name' => 'Admin','email' => 'samhaloman.movie@gmail.com','password' => bcrypt('password'),'role' => 'admin'];
        User::insert($data);
    }
}
