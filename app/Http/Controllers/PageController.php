<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class PageController extends Controller
{
    public function profil()
    {
        return view('profile');
    }
}
