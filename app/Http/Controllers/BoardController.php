<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class BoardController extends Controller
{
    public function create(): View
    {
        return view('features.board.create');
    }
}
