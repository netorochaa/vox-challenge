<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BoardResource;
use App\Models\Board;
use Illuminate\Http\Request;

class BoardIndexController extends Controller
{
    public function __invoke(Request $request)
    {
        return BoardResource::collection(
            Board::query()->orderBy('created_at', 'desc')->get()
        );
    }
}
