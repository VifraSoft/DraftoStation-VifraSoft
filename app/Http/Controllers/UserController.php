<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
<<<<<<< HEAD

class UserController extends Controller
{
=======
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // ... (tus métodos index, create, show, edit no cambian) ...
    
>>>>>>> feature
    // Mostrar todos los usuarios
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }
<<<<<<< HEAD
=======
    
    // Mostrar lista de usuarios en la vista modifyuser
public function modifyUserList()
{
    $usuarios = \App\Models\User::all(); // Trae todos los usuarios
    return view('admin.modifyuser', compact('usuarios'));
}
>>>>>>> feature

    // Mostrar formulario de creación
    public function create()
    {
        return view('users.create');
    }
<<<<<<< HEAD

    // Guardar nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'nickname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
=======
    
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
>>>>>>> feature
            'nickname' => $request->nickname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
<<<<<<< HEAD

        return redirect()->route('welcome')->with('success', 'Usuario creado correctamente.');
    }

=======
        
        // ¡NUEVO! Iniciar sesión automáticamente con el usuario recién creado
        Auth::login($user);
        $request->session()->regenerate(); // Regenerar la sesión por seguridad
        
        return redirect()->route('welcome')->with('success', '¡Cuenta creada! Has iniciado sesión.');
    }
    
>>>>>>> feature
    // Mostrar usuario individual
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
<<<<<<< HEAD

    // Mostrar formulario de edición
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Actualizar usuario existente
    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

=======
    
    // Mostrar formulario de edición
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
            'nickname' => $request->nickname, // <-- CORREGIDO (antes era $request->username)
            'email' => $request->email,
        ]);
        
        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }
    
>>>>>>> feature
    // Eliminar usuario
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
    }
<<<<<<< HEAD
}
=======
    
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
            
            // <-- DEFINIS $user AQUÍ
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
        
        // método logout 
        public function logout(Request $request)
        {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('welcome')->with('success', 'Has cerrado sesión.');
        }
    }
>>>>>>> feature
