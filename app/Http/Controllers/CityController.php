<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function show(City $city)
    {
        $city->load(['boardingHouses', 'boardingHouses.category'])
            ->loadCount('boardingHouses');

        return view('pages.city.show', compact('city'));
    }
}
