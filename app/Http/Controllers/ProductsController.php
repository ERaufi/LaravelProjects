<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use App\Http\Requests\ProductRequest;
use App\Imports\ProductsImport;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Illuminate\Support\Facades\Storage;


class ProductsController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Products::where('name', 'LIKE', "%$query%")->limit(10)->get();
        return response()->json($products);
    }


    //Start Export To Excel=============================================================
    public function export()
    {
        return Excel::download(new ProductExport, 'Products.xlsx');
    }
    // End Export to Excel=============================================================


    //Start Import From Excel=================================================================
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');

        try {
            // Import the data from the Excel file using the import class
            Excel::import(new ProductsImport, $file);

            return response()->json(['success' => true, 'message' => 'Data imported successfully.']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    // End Import From Excel=================================================================


    // Start Generate PDF==========================================================================
    public function generatePDF()
    {
        // Get products from the database
        $products = Products::limit(100)->get();

        // Generate the PDF view
        $pdf = PDF::loadView('PDF.Products', compact('products'));

        // Customize the PDF settings (optional)
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'isFontSubsettingEnabled' => true,
        ]);
        $pdf->getDomPDF()->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed' => TRUE,
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                ]
            ])
        );

        // Save or display the PDF (as needed)
        return $pdf->stream('product_list.pdf');
    }
    // End Generate PDF==========================================================================





    // Start Export From CSV=====================================================================

    public function exportToCSV()
    {
        $products = Products::all();

        if ($products->isEmpty()) {
            return redirect()->back()->with('error', 'No data to export.');
        }

        $csvFileName = 'products.csv';

        // Check if the file exists
        if (!Storage::exists($csvFileName)) {
            // Create a new empty CSV file with the header row
            $csvHeader = [
                'ID',
                'Name',
                'Quantity',
                'Buying Price',
                'Selling Price',
                'Description',
                'Image URL',
                'Weight',
                'Created At',
                'Updated At',
            ];

            Storage::put($csvFileName, implode(',', $csvHeader));
        }

        // Append the CSV data to the file
        foreach ($products as $product) {
            $csvData = [
                $product->id,
                $product->name,
                $product->quantity,
                $product->buyingPrice,
                $product->sellingPrice,
                $product->description,
                $product->image_url,
                $product->weight,
                $product->created_at,
                $product->updated_at,
            ];

            Storage::append($csvFileName, implode(',', $csvData));
        }

        // Get the path to the saved CSV file
        $csvFilePath = Storage::path($csvFileName);

        // Provide the path to the saved CSV file for download
        return response()->download($csvFilePath)->deleteFileAfterSend(true);
    }


    public function importCSV(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        if ($request->hasFile('csv_file')) {
            $file = $request->file('csv_file');
            $path = $file->getRealPath();
            $data = array_map('str_getcsv', file($path));

            // Assuming the first row contains headers
            $headers = array_shift($data);

            foreach ($data as $row) {
                $product = new Products();
                $product->name = $row[0];
                $product->quantity = $row[1];
                $product->buyingPrice = $row[2];
                $product->sellingPrice = $row[3];
                $product->description = $row[4] ?? null;
                $product->image_url = $row[5] ?? null;
                if ($row[6] == '' || $row[6] == null) {
                    $product->weight = null;
                } else {
                    $product->weight = $row[6] ?? null;
                }

                $product->save();
            }

            return redirect('csv')->with('success', 'CSV data imported successfully.');
        }

        return redirect()->route('showImportForm')->with('error', 'Please provide a valid CSV file.');
    }
    // End Export From CSV=====================================================================



























    // Start CRUD=====================================================================================
    public function index()
    {
        $products = Products::paginate(10);
        return view('CRUD.index', compact('products'));
    }

    public function create()
    {
        return view('CRUD.create');
    }

    public function store(ProductRequest $request)
    {
        Products::create($request->all());
        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    public function edit(Products $product)
    {
        return view('CRUD.edit', compact('product'));
    }

    public function update(ProductRequest $request, Products $product)
    {
        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Products $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
    // Start CRUD=====================================================================================
}
