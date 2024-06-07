<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Commune;
use App\Http\Controllers\Controller;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $commune = Commune::where('id_com', $request->input('id_com'))->first();
        $customer = Customer::create([
            'dni' => $request->input('dni'),
            'id_reg' => $commune->id_reg,
            'id_com' => $request->input('id_com'),
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'address' => $request->input('address'),
        ]);

        return response()->json([
            'success' => true,
            'data' => $customer,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $customer)
    {
        $foundBy = $request->foundBy;
        $customer2 = Customer::where($foundBy, $customer);
        $data = [
            'name' => $customer2->name,
            'last_name' => $customer2->last_name,
            'address' => $customer2->address ?? null,
            'region' => $customer2->region->description,
            'commune' => $customer2->commune->description,
        ];
        return response()->json([
            'success' => true,
            'data' => $data,
        ], 201); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $user_to_delete = $request->attributes->get("customer");
        $user_to_delete->status = "trash";
        $user_to_delete->save();

        return response()->json([
            'success' => true,
        ], 201); 
    }
}
