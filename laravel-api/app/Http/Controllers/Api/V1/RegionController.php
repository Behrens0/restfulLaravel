<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
class RegionController extends Controller
{
    public function store(Request $request)
    {
        // Create a new region with the status set to 'A'
        $region = Region::create([
            'description' => $request->input('description'),
            'status' => 'A', // Default status
        ]);
        return response()->json([
            'success' => true,
            'data' => $region,
        ], 201);
    }
}
