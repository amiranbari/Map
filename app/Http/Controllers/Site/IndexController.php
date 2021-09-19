<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Location;

class IndexController extends Controller
{
    public function index()
    {
        $categories = Category::query()->actives()->latest()->get();
        $locations  = Location::query()->actives()->get();
        return view('site.index', compact('categories', 'locations'));
    }
}
