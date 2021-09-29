<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Location;

class LocationController extends Controller
{
    public function index()
    {
        return view('panel.locations.index', [
            'page_description' => '- در این قسمت میتوانید لیست مکان ها را مشاهده کنید',
            'page_title'       => 'لیست مکان ها',
            'locations'        =>  Location::all()
        ]);
    }

    public function updateStatus(Location $location)
    {
        $location->update([
            'status'    =>  $location->status == Location::ACTIVE ? Location::INACTIVE : Location::ACTIVE
        ]);

        return back()->with('success', 'وضعیت با موفقیت ویرایش شد');
    }
}
