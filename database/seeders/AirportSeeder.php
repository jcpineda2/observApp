<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            DB::table('airports')->insert([
                'name' => "Aeropuerto Int. Ministro Pistarini (Ezeiza)",
                'country_id' => Country::query()->where('name','like','%argentina%')->pluck('id'),
                'city_id' =>City::query()->where(['country' =>  function ($query) {
                $query->where('name', 'like', '%argentina%')->get();}])->pluck('id')
            ]);
    }
}
