<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoardCreateRequest;
use App\Models\Board;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class BoardController extends Controller
{
    public function create(): View
    {
        return view('features.board.create');
    }

    public function store(BoardCreateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Board::create($validated);

        return redirect()->route('home')->with('success', 'Board created successfully');
    }
}
