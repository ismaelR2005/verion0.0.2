<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Muestra el formulario de inicio de sesion.
    public function showLogin()
    {
        return view('auth.login');
    }

    // Muestra el formulario para crear una cuenta.
    public function showRegister()
    {
        return view('auth.register');
    }

    // Valida credenciales y crea la sesion del usuario.
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Las credenciales no coinciden.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('empleados.index'));
    }

    // Registra un usuario nuevo y lo deja con sesion iniciada.
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create($data);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('empleados.index');
    }

    // Cierra la sesion y protege el token actual.
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
