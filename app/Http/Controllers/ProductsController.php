<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use App\Imports\ProductsImport;
use App\Models\Products;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;


class ProductsController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Products::where('name', 'LIKE', "%$query%")->limit(10)->get();
        return response()->json($products);
    }




    //Start Export To Excel
    public function export()
    {
        return Excel::download(new ProductExport, 'Products.xlsx');
    }
    // End Export to Excel


    //Start Import From Excel
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
    // End Import From Excel



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
}
