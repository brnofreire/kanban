<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Category $category)
    {
        $this->authorize('update', $category->board);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $position = $category->tasks()->max('position') + 1;

        $task = $category->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'position' => $position,
        ]);

        return response()->json([
            'success' => true,
            'task' => $task
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task->category->board);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task->update($request->only(['title', 'description']));

        return response()->json([
            'success' => true,
            'task' => $task
        ]);
    }

    /**
     * Move task to another category and update positions.
     */
    public function move(Request $request, Task $task)
    {
        $this->authorize('update', $task->category->board);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'position' => 'required|integer',
        ]);

        $newCategory = Category::findOrFail($request->category_id);

        // Ensure the new category belongs to the same board
        if ($task->category->board_id !== $newCategory->board_id) {
            return response()->json(['error' => 'Invalid category'], 403);
        }

        $task->update([
            'category_id' => $request->category_id,
            'position' => $request->position,
        ]);

        // Reorder tasks in the new category
        $this->reorderTasks($newCategory);

        return response()->json([
            'success' => true,
            'task' => $task
        ]);
    }

    /**
     * Update positions of tasks.
     */
    public function updatePositions(Request $request, Category $category)
    {
        $this->authorize('update', $category->board);

        $request->validate([
            'positions' => 'required|array',
            'positions.*.id' => 'required|exists:tasks,id',
            'positions.*.position' => 'required|integer',
        ]);

        foreach ($request->positions as $position) {
            Task::where('id', $position['id'])
                ->where('category_id', $category->id)
                ->update(['position' => $position['position']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('update', $task->category->board);

        $task->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Reorder tasks in a category.
     */
    private function reorderTasks(Category $category)
    {
        $tasks = $category->tasks()->orderBy('position')->get();

        foreach ($tasks as $index => $task) {
            $task->update(['position' => $index]);
        }
    }
}
