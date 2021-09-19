<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function store(Request $request)
    {
        Location::query()->create([
            'title'         =>  $request->title,
            'category_id'   =>  $request->category,
            'lat'           =>  $request->latlng['lat'],
            'lng'           =>  $request->latlng['lng']
        ]);

        return response()->json([
            'status'       =>  200,
            'message'      =>  'Location stored successfully.'
        ], 200);
    }
}
