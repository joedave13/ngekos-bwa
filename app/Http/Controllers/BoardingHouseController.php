<?php

namespace App\Http\Controllers;

use App\Models\BoardingHouse;
use App\Models\Category;
use App\Models\City;
use Illuminate\Http\Request;

class BoardingHouseController extends Controller
{
    public function show(BoardingHouse $boardingHouse)
    {
        $boardingHouse->load(['boardingHouseImages', 'facilities', 'rooms', 'testimonials', 'city', 'category']);

        return view('pages.boarding-house.show', compact('boardingHouse'));
    }

    public function showAvailableRoom(BoardingHouse $boardingHouse)
    {
        $boardingHouse->load(['rooms', 'city', 'category']);

        return view('pages.boarding-house.rooms', compact('boardingHouse'));
    }

    public function find()
    {
        $cities = City::query()->get();
        $categories = Category::query()->get();

        return view('pages.boarding-house.find', compact('cities', 'categories'));
    }

    public function findResult(Request $request)
    {
        $nameSearch = $request->name;
        $citySearch = $request->city;
        $categorySearch = $request->category;

        $boardingHouseQuery = BoardingHouse::with(['category', 'city'])->withSum('rooms as total_room_capacity', 'capacity');

        if ($nameSearch) {
            $boardingHouseQuery->where('name', 'like', '%' . $nameSearch . '%');
        }

        if ($citySearch) {
            $boardingHouseQuery->where('city_id', $citySearch);
        }

        if ($categorySearch) {
            $boardingHouseQuery->where('category_id', $categorySearch);
        }

        $boardingHouses = $boardingHouseQuery->get();
        $boardingHouseResultCount = $boardingHouseQuery->count();

        return view('pages.boarding-house.find-result', compact('boardingHouses', 'boardingHouseResultCount'));
    }
}
