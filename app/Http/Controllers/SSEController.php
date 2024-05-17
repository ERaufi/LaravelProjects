<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use App\Models\Notifications;
use App\Models\Products;
use App\Models\ProductTransactions;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class SSEController extends Controller
{
    //
    public function sendSSE()
    {
        if (Auth::check()) {
            $notifications = Notifications::where('user_id', Auth()->user()->id)
                ->where('is_send', 0)
                ->first();

            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            header('Connection: keep-alive');

            if ($notifications) {
                $eventData = [
                    'message' => $notifications->message,
                ];

                echo "data:" . json_encode($eventData) . "\n\n";
                $notifications->is_send = 1;
                $notifications->update();
            } else {
                echo "\n\n";
            }

            ob_flush();
            flush();
        }
    }



    public function sseForDashboard()
    {

        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');


        if (Cache::has('perMonth') && Cache::has('totalBuyingAndSelling')) {
            $eventData = [
                'perMonth' => Cache::get('perMonth'),
                'totalBuyingAndSelling' => Cache::get('totalBuyingAndSelling'),
                'randomNumber' => Cache::get('randomNumber'),
                'totalUsers' => Cache::get('totalUsers'),
                'totalProducts' => Cache::get('totalProducts'),
                'totalCountries' => Cache::get('totalCountries'),
            ];

            echo "data:" . json_encode($eventData) . "\n\n";
        } else {

            Cache::rememberForever('perMonth', function () {
                return ProductTransactions::select(
                    DB::raw("SUM(CASE WHEN transaction_type = 'buy' THEN total_price ELSE 0 END) as total_buying"),
                    DB::raw("SUM(CASE WHEN transaction_type = 'sell' THEN total_price ELSE 0 END) as total_selling")
                )
                    ->selectRaw('month(created_at) month')
                    ->selectRaw('monthname(created_at) monthName')
                    ->whereYear('created_at', Carbon::now()->year)
                    ->groupBy('month', 'monthName')
                    ->orderBy('month')
                    ->get();
            });

            Cache::rememberForever('totalBuyingAndSelling', function () {
                return ProductTransactions::select(
                    'product_id',
                    DB::raw("SUM(CASE WHEN transaction_type = 'buy' THEN total_price ELSE 0 END) as total_buying"),
                    DB::raw("SUM(CASE WHEN transaction_type = 'sell' THEN total_price ELSE 0 END) as total_selling")
                )
                    ->groupBy('product_id')
                    ->orderBy(DB::raw('SUM(CASE WHEN transaction_type = "sell" THEN total_price ELSE 0 END)'), 'desc')
                    ->take(8)
                    ->with('products')
                    ->get();
            });



            Cache::rememberForever('totalUsers', function () {
                return User::count();
            });
            Cache::rememberForever('totalProducts', function () {
                return Products::count();
            });
            Cache::rememberForever('totalCountries', function () {
                return Countries::count();
            });
            Cache::rememberForever('randomNumber', function () {
                return rand(0000, 999999);
            });

            echo "\n\n";
        }

        ob_flush();
        flush();

        // sleep(20);
    }
}
