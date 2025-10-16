<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $boards = Auth::user()->boards()->with('categories.tasks')->get();
        return view('boards.index', compact('boards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('boards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $board = Auth::user()->boards()->create($request->all());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'board' => $board
            ]);
        }

        return redirect()->route('boards.index')->with('success', 'Quadro criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board)
    {
        $this->authorize('view', $board);

        $board->load('categories.tasks');
        return view('boards.show', compact('board'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Board $board)
    {
        $this->authorize('update', $board);
        return view('boards.edit', compact('board'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Board $board)
    {
        $this->authorize('update', $board);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $board->update($request->all());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'board' => $board
            ]);
        }

        return redirect()->route('boards.show', $board)->with('success', 'Quadro atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board)
    {
        $this->authorize('delete', $board);

        $board->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('boards.index')->with('success', 'Quadro excluído com sucesso!');
    }
}
