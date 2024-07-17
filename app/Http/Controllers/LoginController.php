<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use App\Models\User;

//CIPHER:
use App\Http\Controllers\AESCipher;

class LoginController extends Controller
{
    /**
     * Display login page.
     *
     * @return Renderable
     */
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            
            $aes = new AESCipher;

            $request->session()->regenerate();

            $user = User::where(['id' => Auth::user()->id])->first();
            $authToken = $user->createToken(\Str::random(50))->plainTextToken;
            $request->session()->put('token', $authToken);

            if(auth()->user()->role == 1)
                return redirect()->intended('admin-dashboard');
            if(auth()->user()->role == 2)
                return redirect()->intended('teacher-dashboard');
            if(auth()->user()->role == 3) {
                if(auth()->user()->Students->status == 1) {
                    return redirect()->intended('take-exams?student='.$aes->encrypt(Auth::user()->id).'?key='.\Str::random(50));
                }
                else {
                    return redirect()->intended('student-dashboard');
                }
            }
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
