<?php

namespace App\Http\Controllers;

use App\Models\Kanban;
use Illuminate\Http\Request;

class KanbanController extends Controller
{
    public function getItems()
    {
        $items = Kanban::orderBy('order')->get();
        return $items;
    }
    public function store(Request $request)
    {
        $lastOrder = Kanban::where('status', $request->status)->max('order');
        $item = new Kanban();
        $item->name = $request->name;
        $item->status = $request->status;
        $item->order = $lastOrder + 1;
        $item->save();

        return response()->json(['item' => $item]);
    }

    public function update(Request $request)
    {
        $task = Kanban::findOrfail($request->id);
        $task->name = $request->name;
        $task->update();

        return response()->json(['task' => $task]);
    }

    public function reorder(Request $request)
    {
        $tasks = $request->tasks;
        foreach ($tasks as $task) {
            $t = Kanban::find($task['id']);
            $t->order = $task['order'];
            $t->status = $task['status'];
            $t->save();
        }

        return response()->json(['message' => 'Tasks order updated successfully']);
    }

    public function destroy(Request $request)
    {
        Kanban::where('id', $request->id)->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
