<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::all(); // Obtener todos los usuarios
        return view('usuarios.index', compact('usuarios'));
    }

    // Método para editar un usuario
    public function edit($id)
    {
    $usuario = User::findOrFail($id);

    // Verifica si el usuario autenticado es el mismo que el usuario que se está editando
    if (auth()->user()->id == $usuario->id) {
        // No permitir cambiar el rol si es el mismo usuario
        return view('usuarios.edit', compact('usuario'))->with('disableRole', true);
    }

    return view('usuarios.edit', compact('usuario'));
    }

    

    // Método para almacenar un nuevo usuario en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users|regex:/^[\w\.-]+@[\w\.-]+\.\w{2,}$/',
            'password' => 'required|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $role = auth()->user()->role == 'admin' ? $request->role : 'user';
    
        $profilePicturePath = 'usuarios/default-profile.png'; // Ruta relativa
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('usuarios', 'public');
        }
    
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => $role,
            'profile_picture' => $profilePicturePath,
        ]);
    
        return redirect()->route('usuarios.index')->with('success', 'Usuario añadido con éxito.');
    }
 


    

    // Método para eliminar un usuario
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }


    // Método para mostrar el formulario de creación de usuarios
    public function create()
    {
        return view('usuarios.create');
    }


    // Método para actualizar el usuario en la base de datos
    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users,email,' . $usuario->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
    
        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (!Hash::check($request->current_password, $usuario->password)) {
                throw ValidationException::withMessages(['current_password' => 'La contraseña actual es incorrecta.']);
            }
            $usuario->password = Hash::make($request->new_password);
        }
    
        $usuario->name = $request->name;
        $usuario->email = $request->email;
    
        if (Auth::user()->role == 'admin' && Auth::user()->id != $usuario->id) {
            $usuario->role = $request->role;
        }
    
        if ($request->hasFile('profile_picture')) {
            $oldPath = public_path('storage/' . $usuario->profile_picture);
            if ($usuario->profile_picture && file_exists($oldPath)) {
                unlink($oldPath);
            }
    
            $profilePicturePath = $request->file('profile_picture')->store('usuarios', 'public');
            $usuario->profile_picture = $profilePicturePath;
        }
    
        $usuario->save();
    
        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }
    
}
