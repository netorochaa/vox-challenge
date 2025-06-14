<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryIndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $boardId = $request->input('board_id');

        if (!$boardId) {
            abort(404, 'Board ID is required');
        }

        $categories = Category::where('board_id', $boardId)->get();

        return CategoryResource::collection($categories);
    }
}
