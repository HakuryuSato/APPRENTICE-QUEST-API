<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    // GET
    public function index()
    {
        $todos = Todo::all(['id', 'title']);
        return response()->json(['todos' => $todos]);
    }

    // POST
    public function store(Request $request)
    {
        $todo = Todo::create($request->input('todo'));
        return response()->json(['todos' => $todo]);
    }

    // PUT
    public function update(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->update($request->input('todo'));

        return response()->json(['todo' => $todo]);
    }

    // DELETE
    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return response()->noContent();
    }
}
