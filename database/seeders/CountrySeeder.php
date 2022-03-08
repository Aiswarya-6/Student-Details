<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('country')->insert([
            [
                'countryName' => 'India',
            ],
            [
                'countryName' => 'China',
            ]
        ]);

        DB::table('state')->insert([
            [
                'stateName' => 'Kerala',
                'countryId' => '1'
            ],
            [
                'stateName' => 'Tamil Nadu',
                'countryId' => '1'
            ],
            [
                'stateName' => 'Karnadaka',
                'countryId' => '1'
            ],
            [
                'stateName' => 'Gansu',
                'countryId' => '2'
            ],
            [
                'stateName' => 'Beijing',
                'countryId' => '2'
            ],
            [
                'stateName' => 'Tibet',
                'countryId' => '2'
            ]
        ]);
    }
}
