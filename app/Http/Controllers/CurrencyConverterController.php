<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CurrencyConverterController extends Controller
{
    public function sse(Request $request)
    {
        $currency = $request->query('currency', 'USD');
        $apiUrl = "https://open.er-api.com/v6/latest/{$currency}";

        $response = new StreamedResponse(function () use ($apiUrl) {
            while (true) {
                $response = Http::get($apiUrl);
                $result = json_decode($response);
                if (isset($result->result) && $result->result == 'error') {
                    $data['lastUpdated'] = now()->toDateTimeString(); // Add the timestamp
                    $data['rates'] = [];
                    $data['result'] = 'error';
                    echo "data: " . json_encode($data) . "\n\n";
                    ob_flush();
                    flush();

                    sleep(20); // Check every 5 seconds

                } else {
                    $data = $response->json();
                    $data['lastUpdated'] = now()->toDateTimeString(); // Add the timestamp
                    $data['result'] = 'success';
                    echo "data: " . json_encode($data) . "\n\n";
                    ob_flush();
                    flush();

                    sleep(20); // Check every 5 seconds

                }
            }
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');

        return $response;
    }
}
