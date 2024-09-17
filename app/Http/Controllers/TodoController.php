<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

/**
 * @OA\Info(title="Todo API", version="1.0.0")
 */
class TodoController extends Controller
{
    // GET
    /**
     * @OA\Get(
     *     path="/todos",
     *     summary="Get list of todos",
     *     @OA\Response(response="200", description="A list of todos")
     * )
     */
    public function index()
    {
        $todos = Todo::all(['id', 'title']);
        return response()->json(['todos' => $todos]);
    }

    /**
     * @OA\Post(
     *     path="/todos",
     *     summary="Add a new todo",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title"},
     *             @OA\Property(property="title", type="string", example="Buy groceries")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Todo created successfully")
     * )
     */
    // POST
    public function store(Request $request)
    {
        $todo = Todo::create($request->input('todo'));
        return response()->json(['todos' => $todo]);
    }

    /**
     * @OA\Put(
     *     path="/todos/{id}",
     *     summary="Update a todo",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title"},
     *             @OA\Property(property="title", type="string", example="Read a book")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Todo updated successfully")
     * )
     */
    // PUT
    public function update(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->update($request->input('todo'));

        return response()->json(['todo' => $todo]);
    }

    /**
     * @OA\Delete(
     *     path="/todos/{id}",
     *     summary="Delete a todo",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Todo deleted successfully")
     * )
     */
    // DELETE
    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return response()->noContent();
    }
}
