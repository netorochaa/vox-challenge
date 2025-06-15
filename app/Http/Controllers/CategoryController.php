<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryCreateRequest;
use App\Models\Board;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function create(Request $request, int $boardId): View
    {
        $board = Board::findOrFail($boardId);

        return view('features.board.category.create', ['board' => $board]);
    }

    public function store(CategoryCreateRequest $request): RedirectResponse
    {
        $category = Category::create($request->validated());

        return redirect()->route('board.view', $category->board->id)->with('success', 'Categoria criada com sucesso');
    }
}
