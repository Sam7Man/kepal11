<?php

use Illuminate\Database\Seeder;
use App\Alamattoko;
class AlamattokoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['city_id' => '121','detail' => 'Barat'];
        Alamattoko::insert($data);
    }
}
