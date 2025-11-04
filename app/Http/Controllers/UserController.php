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

    // Mostrar formulario de creación
    public function create()
    {
        return view('users.create');
    }

    /**
     * MEJORA 2: Auto-login después de registrarse.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nickname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6', // O usa 'confirmed' si tienes campo "confirmar contraseña"
        ]);

        $user = User::create([
            'nickname' => $request->nickname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // ¡NUEVO! Iniciar sesión automáticamente con el usuario recién creado
        Auth::login($user);
        $request->session()->regenerate(); // Regenerar la sesión por seguridad

        return redirect()->route('welcome')->with('success', '¡Cuenta creada! Has iniciado sesión.');
    }

    // Mostrar usuario individual
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    // Mostrar formulario de edición
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
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
            'nickname' => $request->nickname, // <-- CORREGIDO (antes era $request->username)
            'email' => $request->email,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    // Eliminar usuario
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
        // 1. Validar los datos
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // 2. Intentar iniciar sesión (esto busca al usuario Y verifica la contraseña)
        if (Auth::attempt($credentials)) {
            // 3. Si tiene éxito, regenerar sesión y redirigir
            $request->session()->regenerate();

            return redirect()->route('welcome')->with('success', 'Has iniciado sesión correctamente.');
        }

        // 4. Si falla, volver al login con un error
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden.',
        ])->onlyInput('email'); // Solo re-rellena el campo de email
    }

    // Tu método logout ya era perfecto, no necesita cambios.
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome')->with('success', 'Has cerrado sesión.');
    }
}