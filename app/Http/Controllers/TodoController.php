<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    //
    public function index(Request $request)
    {
        $search = $request->get('search');
        $todos = $search ? Todo::where('title', 'like', "%$search%")->get() : Todo::all();
        return response()->json($todos);
    }

    public function store(TodoRequest $request)
    {
        $item = new Todo();
        $item->title = $request->title;
        $item->completed = 0;
        $item->save();

        return response()->json($item, 200);
    }

    public function update(TodoRequest $request)
    {
        $todo = Todo::findOrFail($request->id);
        $todo->update($request->validated());
        return response()->json($todo);
    }

    public function destroy(Request $request)
    {
        Todo::findOrFail($request->id)->delete();
        return response()->json(null, 204);
    }

    public function complete(Request $request)
    {
        $todo = Todo::findOrFail($request->id);
        $todo->completed = 1;
        $todo->save();

        return response()->json($todo);
    }
}
