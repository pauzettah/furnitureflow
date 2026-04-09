<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
   public function store(Request $request)
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'phone' => ['required', 'string', 'max:20'],
        'role' => ['required', 'in:admin,customer,carpenter,delivery'],
        'address' => ['nullable', 'string'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'role' => $request->role,
        'address' => $request->address,
        'password' => Hash::make($request->password),
    ]);

    // Fire the registered event
    event(new Registered($user));

    // REMOVE these lines (they auto-login the user):
    // Auth::login($user);
    // return redirect(route('dashboard', absolute: false));

    // ADD this instead - redirect to login page with success message:
    return redirect()->route('login')->with('success', 'Registration successful! Please login with your credentials.');
}
}