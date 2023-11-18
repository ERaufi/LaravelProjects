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

    public function uploadCroppedImage(Request $request)
    {
        $imageData = $request->input('image');

        // Decode the base64 image data
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);
        $imageData = base64_decode($imageData);

        // Generate a unique filename
        $filename = 'cropped_image_' . time() . '.png';

        // Save the image to the server
        file_put_contents(public_path('uploads/' . $filename), $imageData);

        // You can save the filename to the database or perform any other necessary actions
        $item = new DropZone();
        $item->filename = $filename;
        $item->save();
        return response()->json(['success' => true, 'filename' => $filename]);
    }
}
