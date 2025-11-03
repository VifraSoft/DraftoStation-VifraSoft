<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
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

    // Guardar nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'nickname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'nickname' => $request->nickname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('welcome')->with('success', 'Usuario creado correctamente.');
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

    // Eliminar usuario
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
