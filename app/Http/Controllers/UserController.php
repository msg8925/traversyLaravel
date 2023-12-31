<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    //
    public function create() {

        return view('users.register');
    }

    // Create New User
    public function store(Request $request) {

        $formFields = $request->validate([

            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        ]);

        // Hash password
        $formFields['password'] = bcrypt($formFields['password']);

        // Create User
        $user = User::create($formFields);

        // Login New User
        auth()->login($user);

        return redirect('/')->with('message', 'User Created and Logged In');
    }

    // Log out User
    public function logout(Request $request) {

        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out successfully.');
    }

    // Show Login Form
    public function login() {

        return view('users.login');
    }


    // Authenticate User
    public function authenticate(Request $request) {

        $formFields = $request->validate([

            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($formFields)) {

            $request->session()->regenerate();

            return redirect('/')->with('message', 'You are now logged in');
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }
}
