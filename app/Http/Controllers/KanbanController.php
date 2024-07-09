<?php

namespace App\Http\Controllers;

use App\Models\Kanban;
use Illuminate\Http\Request;

class KanbanController extends Controller
{
    public function store(Request $request)
    {
        $lastOrder = Kanban::where('status', $request->input('status'))->max('order');
        $task = new Kanban();
        $task->name = $request->input('name');
        $task->status = $request->input('status', 'todo');
        $task->order = $lastOrder + 1;
        $task->save();

        return response()->json(['task' => $task], 201);
    }

    public function update(Request $request, Kanban $task)
    {
        $task->name = $request->input('name');
        $task->status = $request->input('status');
        $task->order = $request->input('order');
        $task->save();

        return response()->json(['task' => $task]);
    }

    public function updateOrder(Request $request)
    {
        $tasks = $request->input('tasks');
        foreach ($tasks as $task) {
            $t = Kanban::find($task['id']);
            $t->order = $task['order'];
            $t->status = $task['status'];
            $t->save();
        }

        return response()->json(['message' => 'Tasks order updated successfully']);
    }

    public function destroy(Kanban $task)
    {
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
