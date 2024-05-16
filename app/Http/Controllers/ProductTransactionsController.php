<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\ProductTransactions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProductTransactionsController extends Controller
{
    //
    public function index()
    {
        $products = Products::all();
        return view('welcome', compact('products'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'transaction_type' => 'required|in:buy,sell',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|integer|min:0',
        ]);

        $productTransaction = new ProductTransactions();
        $productTransaction->product_id = $validatedData['product_id'];
        $productTransaction->transaction_type = $validatedData['transaction_type'];
        $productTransaction->quantity = $validatedData['quantity'];
        $productTransaction->price = $validatedData['price'];
        $productTransaction->total_price = $validatedData['quantity'] * $validatedData['price'];
        $productTransaction->save();

        Cache::flush();
        return response()->json(['success' => true, 'message' => 'Transaction saved successfully']);
    }

    // public function getChartsData(Request $request)
    // {
    //     $perMonth = ProductTransactions::select(
    //         DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
    //         DB::raw("SUM(CASE WHEN transaction_type = 'buy' THEN total_price ELSE 0 END) as total_buying"),
    //         DB::raw("SUM(CASE WHEN transaction_type = 'sell' THEN total_price ELSE 0 END) as total_selling")
    //     )
    //         ->whereYear('created_at', Carbon::now()->year)
    //         ->groupBy('month')
    //         ->orderBy('month')
    //         ->get();


    //     $totalBuyingAndSelling = ProductTransactions::select(
    //         'product_id',
    //         DB::raw("SUM(CASE WHEN transaction_type = 'buy' THEN total_price ELSE 0 END) as total_buying"),
    //         DB::raw("SUM(CASE WHEN transaction_type = 'sell' THEN total_price ELSE 0 END) as total_selling")
    //     )
    //         ->groupBy('product_id')
    //         ->orderBy(DB::raw('SUM(CASE WHEN transaction_type = "sell" THEN total_price ELSE 0 END)'), 'desc')
    //         ->take(8)
    //         ->with('products')
    //         ->get();

    //     return response()->json([
    //         'perMonth' => $perMonth,
    //         'totalBuyingAndSelling' => $totalBuyingAndSelling
    //     ], 200);
    // }
}
