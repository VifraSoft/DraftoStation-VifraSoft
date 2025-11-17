<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // ... (tus métodos index, create, show, edit no cambian) ...

    // Mostrar todos los usuarios
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Mostrar lista de usuarios en la vista modifyuser
    public function modifyUserList()
    {
        $usuarios = \App\Models\User::all(); // Trae todos los usuarios
        return view('admin.modifyuser', compact('usuarios'));
    }

    /**
     * MEJORA 2: Auto-login después de registrarse.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nickname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'nickname' => $request->nickname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('welcome')->with('success', '¡Cuenta creada! Has iniciado sesión.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.edituser', compact('user'));
    }

    /**
     * BUG 1: Corregido $request->username por $request->nickname.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nickname' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'nickname' => $request->nickname,
            'email' => $request->email,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
    }

    /**
     * MEJORA 3: Refactorizado para usar Auth::attempt() (más limpio).
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user && $user->is_admin) {
                return redirect()->route('admin')->with('success', 'Bienvenido administrador.');
            }

            return redirect()->route('welcome')->with('success', 'Has iniciado sesión correctamente.');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome')->with('success', 'Has cerrado sesión.');
    }
}
