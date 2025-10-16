<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Board $board)
    {
        $this->authorize('update', $board);

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $position = $board->categories()->max('position') + 1;

        $category = $board->categories()->create([
            'title' => $request->title,
            'position' => $position,
        ]);

        return response()->json([
            'success' => true,
            'category' => $category->load('tasks')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category->board);

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $category->update($request->only('title'));

        return response()->json([
            'success' => true,
            'category' => $category
        ]);
    }

    /**
     * Update the position of categories.
     */
    public function updatePositions(Request $request, Board $board)
    {
        $this->authorize('update', $board);

        $request->validate([
            'positions' => 'required|array',
            'positions.*.id' => 'required|exists:categories,id',
            'positions.*.position' => 'required|integer',
        ]);

        foreach ($request->positions as $position) {
            Category::where('id', $position['id'])->update(['position' => $position['position']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->authorize('update', $category->board);

        $category->delete();

        return response()->json(['success' => true]);
    }
}
