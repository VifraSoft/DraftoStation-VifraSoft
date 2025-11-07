<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Mostrar panel principal
    public function index()
    {
        return view('admin.admin');
    }

    // Lista de usuarios
    public function listUsers()
    {
        $usuarios = User::all();
        return view('admin.modifyuser', compact('usuarios'));
    }

    // Formulario para crear usuario
    public function createUser()
    {
        return view('admin.createuser');
    }

    // Crear usuario (sin iniciar sesión)
    public function storeUser(Request $request)
    {
        $request->validate([
            'nickname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'nickname' => $request->nickname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin')->with('success', 'Usuario creado correctamente.');
    }

    // Formulario de edición de usuario
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edituser', compact('user'));
    }

    // Actualizar usuario
    public function updateUser(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'nickname' => 'required',
        'email' => 'required|email|unique:users,email,' . $id,
        'password' => 'nullable|min:6',
    ]);

    $data = [
        'nickname' => $request->nickname,
        'email' => $request->email,
    ];

    // Si el admin ingresó una nueva contraseña, la encripta y actualiza
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $user->update($data);

    return redirect()->route('admin.users')->with('success', 'Usuario actualizado correctamente.');
}

    // Eliminar usuario
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin')->with('success', 'Usuario eliminado correctamente.');
    }
}
