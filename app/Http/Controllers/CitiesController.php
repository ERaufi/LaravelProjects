<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\Countries;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    //
    public function getCityBasedOnCountry(Request $request)
    {
        return Cities::where('country_code', $request->country_code)->get();
    }

    public function searchCities(Request $request)
    {
        return Cities::where('country_code', $request->country)
            ->where('name', 'like', '%' . $request->search . '%')
            ->get();
    }
}
