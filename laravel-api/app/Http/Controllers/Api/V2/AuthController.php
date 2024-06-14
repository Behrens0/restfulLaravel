<?php

namespace App\Http\Controllers\Api\V2;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Token;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        

        return redirect()->route('login1');
    }

    public function showLoginForm()
    {
        return view('loginAuth');
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)
                    ->first();

        if ($user) {
            $email = $request->email;
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
            Auth::login($user);

            $request->session()->regenerate();

            $cookie = cookie('encrypted_token', $encrypted_token, 60, '/', null, false, false);
            return response()->json(['redirectUrl' => route('main')])->withCookie($cookie);
        }
        
        return response()->json([
            'errors' => [
                'email' => ['The provided credentials do not match our records.'],
                'password' => ['The provided credentials do not match our records.'],
            ]
        ], 422);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $authorizationHeader = $request->headers->get('Authorization');
        if (!$authorizationHeader || !preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
            return response()->json([''=> ''])->withCookie('');
        }
        $token = $matches[1];
        $tokenDetails = Token::where('token', $token)->first();
        $tokenDetails->delete();
        Cookie::forget('encrypted_token');//a
        return response()->json(['redirectUrl' => route('login1')]);
    }

    public function dashboard()
    {
        return view('main');
    }
}
