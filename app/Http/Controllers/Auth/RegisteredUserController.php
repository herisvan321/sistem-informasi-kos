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
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'type_user' => ['required', 'string', 'in:pencari-kos,pemilik-kos'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type_user' => $request->type_user,
            'status' => $request->type_user === 'pemilik-kos' ? 'pending' : 'active',
        ]);

        $user->assignRole($request->type_user);

        event(new Registered($user));

        Auth::login($user);

        return $this->redirectByUserRole($user);
    }

    protected function redirectByUserRole($user): RedirectResponse
    {
        if ($user->hasRole('super-admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('pemilik-kos')) {
            return redirect()->route('pemilik-kos.dashboard');
        }

        return redirect('/');
    }
}
