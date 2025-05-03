<?php

namespace App\Http\Controllers;

use App\Models\BoardingHouse;
use App\Models\Category;
use App\Models\City;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::query()->withCount('boardingHouses')->get();
        $popularBoardingHouses = BoardingHouse::with(['category', 'city'])->withSum('rooms as total_room_capacity', 'capacity')->where('is_popular', true)->get();
        $cities = City::query()->withCount('boardingHouses')->get();
        $boardingHouses = BoardingHouse::with(['category', 'city'])->withSum('rooms as total_room_capacity', 'capacity')->latest()->get();

        return view('pages.home.index', compact('categories', 'popularBoardingHouses', 'cities', 'boardingHouses'));
    }
}
