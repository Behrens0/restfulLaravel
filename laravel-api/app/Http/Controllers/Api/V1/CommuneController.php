<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Commune;
use App\Http\Controllers\Controller;
class CommuneController extends Controller
{
    public function store(Request $request)
    {
        // Create a new commune with the status set to 'A'
        $commune = Commune::create([
            'description' => $request->input('description'),
            'status' => 'A', 
            'id_reg' => 1,
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
