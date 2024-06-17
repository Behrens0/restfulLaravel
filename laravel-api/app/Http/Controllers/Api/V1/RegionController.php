<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Http\Controllers\Controller;
use App\Models\Commune;
use Illuminate\Support\Facades\Log;
class RegionController extends Controller
{
    public function store(Request $request)
    {
        $region = Region::create([
            'description' => $request->regionName,
            'status' => 'A', 
        ]);
        return response()->json([
            'success' => true,
            'data' => $region,
        ], 201);
    }

    public function index() {
        $regions = Region::paginate(10, ['*'], 'regions_page');
        $communes = Commune::paginate(10, ['*'], 'communes_page');
        return view('InitialView', compact('regions', 'communes'));
    }
}
