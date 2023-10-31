<?php

namespace App\Http\Controllers;

use App\Models\FormBuilder;
use App\Models\Forms;
use Illuminate\Http\Request;

class FormsController extends Controller
{
    //
    public function create(Request $request)
    {
        $request->request->remove('_token');
        $item = new Forms();
        $item->form_id = $request->form_id;
        $request->request->remove('form_id');
        $item->form = $request->all();
        $item->save();
        return redirect('form-builder')->with('success', 'Form deleted successfully');
    }


}
