<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Commune;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        // Fetch customers where status is not 'trash' and paginate the results
        $customers = Customer::where('status', '!=', 'trash')->paginate(10);
        return view('customer', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info("hola");
        $commune = Commune::where('id_com', $request->customerCommune)->first();
        $customer = Customer::create([
            'dni' => $request->customerDni,
            'id_reg' => $commune->id_reg,
            'id_com' => $request->customerCommune,
            'email' => $request->customerEmail,
            'name' => $request->customerName,
            'last_name' => $request->customerLastName,
            'address' => $request->customerAddress,
        ]);

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
        
        $ident = (string)$identifier;
        Log::info($ident);
        $foundBy = $request->attributes->get('foundBy');
        Log::info($foundBy);
        $customer2 = Customer::where($foundBy, $ident)->first();
        Log::info($customer2->name);
        // $data = [
        //     'name' => $customer2->name,
        //     'last_name' => $customer2->last_name,
        //     'address' => $customer2->address ?? null,
        //     'region' => $customer2->region->description,
        //     'commune' => $customer2->commune->description,
        // ];
        // $data2 = [
        //     'email' => $customer2->email,
        //     'name' => $customer2->name,
        //     'last_name' => $customer2->last_name,
        //     'address' => $customer2->address ?? null,
        //     'region' => $customer2->id_reg,
        //     'commune' => $customer2->id_com,
        //     'dni' => $customer2->dni,
        // ];
        return response()->json([
            'success' => true,
            'data' => $customer2,
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
        Log::info('sdjfhs');
        $user_to_delete = $request->attributes->get("customer");
        $user_to_delete->status = "trash";
        $user_to_delete->save();

        return response()->json([
            'success' => true,
        ], 201); 
    }
}
