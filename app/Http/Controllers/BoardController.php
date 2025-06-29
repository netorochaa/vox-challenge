<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoardCreateRequest;
use App\Http\Requests\BoardUpdateRequest;
use App\Models\Board;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function create(): View
    {
        return view('features.board.create');
    }

    public function store(BoardCreateRequest $request): RedirectResponse
    {
        Board::create($request->validated());

        return redirect()->route('home')->with('success', 'Quadro criado com sucesso');
    }

    public function edit(Request $request, int $id): View
    {
        $board = Board::findOrFail($id);

        return view('features.board.edit', ['board' => $board]);
    }

    public function update(BoardUpdateRequest $request, int $id): RedirectResponse
    {
        Board::find($id)->update($request->validated());

        return redirect()->route('home')->with('success', 'Quadro atualizado com sucesso');
    }

    public function show(Request $request, int $id): View
    {
        $board = Board::findOrFail($id);

        return view('features.board.view', ['board' => $board]);
    }

    public function delete(Request $request, int $id): RedirectResponse
    {
        $board = Board::findOrFail($id);
        $board->delete();

        return redirect()->route('home')->with('success', 'Quadro deletado com sucesso');
    }
}
