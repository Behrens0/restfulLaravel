<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Commune;
use App\Http\Controllers\Controller;
class CommuneController extends Controller
{
    public function store(Request $request)
    {
        $commune = Commune::create([
            'description' => $request->communeName,
            'status' => 'A', 
            'id_reg' => $request->communeReg,
        ]);
        return response()->json([
            'success' => true,
            'data' => $commune,
        ], 201);
    }

    public function index() {
        $communes = Commune::all();
        return view('InitialView', compact('communes'));
    }
}
