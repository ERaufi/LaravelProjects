<?php

namespace App\Http\Controllers;

use App\Models\DropZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DropZoneController extends Controller
{
    //

    //start for Lazy Load
    public function index()
    {
        $images = DropZone::all();
        return response()->json($images);
    }
    // End Lazy Load

    public function upload(Request $request)
    {
        try {
            if ($request->hasFile('images')) {
                $filename = [];

                foreach ($request->file('images') as $image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('images'), $imageName);
                    $imageModel = DropZone::create(['filename' => $imageName]);
                    $filename[] = $imageModel->filename;
                }

                return response()->json(['success' => true, 'filename' => $filename]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
