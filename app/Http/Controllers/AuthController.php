<?php

namespace App\Http\Controllers;

//Models
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

//facades
use Illuminate\Support\Facades\Auth; 

class AuthController extends Controller
{
    /**
     * Show the form for creating the resource.
     */
    public function create()
    {
        return inertia('Login/Index');
    }

    /**
     * Store the newly created resource in storage.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);



        if(!Auth::attempt($credentials, true)) {
            throw ValidationException::withMessages([
                'email' => 'No valid email found',
                'password' => 'Authentication failed'
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended('tracker');
    }


    /**
     * Remove the resource from storage.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect()->route('login');
    }
}
