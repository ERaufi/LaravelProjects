<?php

namespace App\Http\Controllers;

use App\Models\FormBuilder;
use App\Models\Forms;
use Illuminate\Http\Request;

class FormsController extends Controller
{
    //
    public function read(Request $request)
    {
        $item = FormBuilder::findOrFail($request->id);
        return $item;
    }

    public function create(Request $request)
    {
        $formID = $request->form_id;
        $request->request->remove('_token');
        $request->request->remove('form_id');
        $allData = $request->all();

        // Check if any file is attached to the request
        if ($request->hasFile('*')) {
            // Handle file upload
            foreach ($request->allFiles() as $key => $files) {

                // Check if it's a valid file
                if ($files->isValid()) {
                    // Generate a unique name for the file
                    $imageName = time() . '_' . $files->getClientOriginalName();
                    // Move the file to the desired location
                    $files->move(public_path('images'), $imageName);
                    // Add the file name to the validated data
                    $allData['files'][] = ['key' => $imageName, 'path' => 'images/' . $imageName];
                }
            }
        }


        $item = new Forms();
        $item->form_id = $formID;
        $item->form = $allData;
        $item->save();
        return redirect('form-builder')->with('success', 'Form deleted successfully');
    }
}
