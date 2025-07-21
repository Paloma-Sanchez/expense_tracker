<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//facades
use Illuminate\Support\Facades\Hash;

//models
use App\Models\User;

class UserAccountController extends Controller
{
    public function create() {
        return inertia('UserAccount/Create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|min:0|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:4|max:30'
        ]);

        User::create($validated);

        return redirect()
                ->route('login')
                ->with('success', 'Account created  ');
    }

}
