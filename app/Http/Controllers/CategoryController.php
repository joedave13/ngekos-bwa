<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $category->load(['boardingHouses', 'boardingHouses.city'])
            ->loadCount('boardingHouses');

        return view('pages.category.show', compact('category'));
    }
}
