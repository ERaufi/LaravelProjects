<?php

namespace App\Http\Controllers;

use App\Models\FormBuilder;
use Illuminate\Http\Request;

class FormBuilderController extends Controller
{
    //
    public function index()
    {
        $forms = FormBuilder::all();
        return view('FormBuilder.index', compact('forms'));
    }

    public function read(Request $request)
    {
        $item = FormBuilder::findOrFail($request->id);

        return $item;
    }

    public function create(Request $request)
    {
        $item = new FormBuilder();
        $item->name = $request->name;
        $item->content = $request->form;
        $item->save();

        return response()->json('added successfully');
    }

    public function editData(Request $request)
    {
        return FormBuilder::where('id', $request->id)->first();
    }

    public function update(Request $request)
    {
        $item = FormBuilder::findOrFail($request->id);
        $item->name = $request->name;
        $item->content = $request->form;
        $item->update();
        return response()->json('updated successfully');
    }

    public function destroy($id)
    {
        $form = FormBuilder::findOrFail($id);
        $form->delete();

        return redirect('form-builder')->with('success', 'Form deleted successfully');
    }
}
