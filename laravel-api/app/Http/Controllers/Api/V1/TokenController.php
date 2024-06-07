<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Token;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
class TokenController extends Controller
{
    public function store(Request $request)
    {
        Log::info("hola");
        $email = $request->input('email');
        $time = date("H:i:s");
        $date=date("Y-m-d");
        $dateSaved = "{$date}-{$time}";
        $random_number = rand(200, 500); 
        $token_encrypt = "{$email}{$date}{$time}{$random_number}";
        $encrypted_token = sha1($token_encrypt);

        $token = Token::create([
            'token' => $encrypted_token,
            'email' => $email,
            'random_value' => $random_number,
            'login_time' => $dateSaved,
        ]);

        return response()->json([
            'success' => true,
            'message' => "Login succesful",
        ], 201);

    }
}
