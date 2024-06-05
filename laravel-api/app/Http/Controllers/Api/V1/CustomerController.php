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
        $time = date("h:i:sa");
        $data=date("Y/m/d");
        $token_encrypt = "{$customer->email}{$customer->dni}";
        return response()->json([
            'success' => true,
            'data' => $customer,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $identifier)
    {
        $foundBy = $request->foundBy;
        $customer = Customer::where($foundBy, $identifier);
        $data = [
            'name' => $customer->name,
            'last_name' => $customer->last_name,
            'address' => $customer->address ?? null,
            'region' => $customer->region->description,
            'commune' => $customer->commune->description,
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
