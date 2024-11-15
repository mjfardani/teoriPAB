<?php

namespace App\Http\Controllers\api;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CardController extends Controller
{
    public function create()
    {
        $id = DB::table('cards')->insertGetId([
            'balance' => 0,
        ]);
        return response()->json([
            'id' => $id,
            'message' => 'Berhasil'
        ], 200);
    }

    public function list(Request $request)
    {
        $page = $request->input('page', 0);
        $page_size = $request->input('page_size', 10);
        return response()->json([
            'message' => 'Berhasil',
            'cards' => Card::skip($page * $page_size)->take($page_size)->select('id')->get(),
        ], 200);
    }
}
