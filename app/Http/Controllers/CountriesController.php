<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use Illuminate\Http\Request;

class CountriesController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'name', 'order_number', 'created_at', 'updated_at'];
        $orderByColumn = $request->order[0]['column'];
        $orderDirection = $request->order[0]['dir'];
        $query = Countries::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%$search%");
        })
            ->orderBy($columnsForOrderBy[$orderByColumn], $orderDirection);

        $total = $query->count();

        // Apply pagination
        $products = $query->skip($request->start)->take($request->length)->get();

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $products,
        ]);
    }

    public function update(Request $request)
    {
        $item = Countries::findOrFail($request->id);
        $item->name = $request->name;
        $item->update();

        return response()->json('Updated Successfully');
    }

    public function reOrder(Request $request)
    {

        for ($i = 0; $i < count($request->id); $i++) {
            $item = Countries::findOrFail($request->id[$i]);
            $item->order_number = $request->order_number[$i];
            $item->update();
        }

        return response()->json('Order Saved Successfully');
    }


    public function search($query)
    {
        return Countries::select("name")
            ->where('name', 'LIKE', '%' . $query . '%')
            ->get();
    }

    public function select2()
    {
        $countries = Countries::all();
        return view('select2.Index', compact('countries'));
    }

    public function searchSelect2(Request $request)
    {
        return Countries::where('name', 'LIKE', '%' . $request->search . '%')
            ->get();
    }
}
