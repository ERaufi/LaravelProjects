<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SecurityPracticeController extends Controller
{
    //

    public function fileUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,png,pdf|max:2048', // Allow only specific file types
        ]);

        $request->file('file')->store('uploads');
        return "File uploaded!";
    }

    public function PreventingCross_SiteScripting(Request $request)
    {
        return view('comment', ['comment' => request('comment')]);

        // <p>{{ request('comment') }}</p>
        // <p>{{ e(request('comment')) }}</p> <!-- Escapes the output -->
    }
}
