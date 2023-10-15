<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use Illuminate\Http\Request;
use App\Note;

class NotesController extends Controller
{
    public function index()
    {
        $notes = Notes::all();
        return view('notes.index', compact('notes'));
    }

    public function create()
    {
        return view('notes.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        Notes::create($validatedData);

        return redirect('notes')->with('success', 'Note created successfully');
    }

    public function show(Notes $note)
    {
        return view('notes.show', compact('note'));
    }

    public function edit(Notes $note)
    {
        return view('notes.edit', compact('note'));
    }

    public function update(Request $request, Notes $note)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $note->update($validatedData);

        return redirect('notes')->with('success', 'Note updated successfully');
    }

    public function destroy(Notes $note)
    {
        $note->delete();

        return redirect('notes')->with('success', 'Note deleted successfully');
    }
}
