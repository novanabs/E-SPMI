<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SyaratUnggul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SyaratController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // $data = SyaratUnggul::with([
        //     'matriks.userMatrik' => function ($q) use ($userId) {
        //         $q->where('id_users', $userId);
        //     }
        // ])->get();

        $data = SyaratUnggul::with([
            'matriks.subItemElemen',
            'matriks.userSubItemElements' => function ($q) use ($userId) {
                $q->where('id_users', $userId);
            },
            'matriks.userMatrik'          => function ($q) use ($userId) {
                $q->where('id_users', $userId);
            }
        ])->get();

        // dd($data->first());

        return view('SyaratUnggul.index', compact('data'));
    }
}
