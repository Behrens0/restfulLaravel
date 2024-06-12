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

            $cookie = cookie('encrypted_token', $encrypted_token, 60);
            return redirect()->route('main')->withCookie($cookie);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login1');
    }

    public function dashboard()
    {
        return view('main');
    }
}
