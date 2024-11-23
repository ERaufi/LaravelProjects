<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class WeatherController extends Controller
{
    //
    public function index(Request $request)

    {
        $client = new Client();
        $response = $client->request('GET', 'http://api.openweathermap.org/data/2.5/weather', [
            'query' => [
                'q' => $request->city,
                'units' => $request->unit,
                'appid' => "dfgsfgsdf"
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
