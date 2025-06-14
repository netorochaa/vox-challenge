<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BoardIndexResource;
use App\Models\Board;
use Illuminate\Http\Request;

class BoardIndexController extends Controller
{
    public function __invoke(Request $request)
    {
        return BoardIndexResource::collection(
            Board::query()->get()
        );
    }
}
