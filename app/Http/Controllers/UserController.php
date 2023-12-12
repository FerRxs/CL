<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    public function index()
    {
        $users = User::all();
        return view('privado.users.index', compact('users'));
    }

    public function create()
    {
        return view('privado.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'address' => 'nullable|string',
            'image' => 'nullable|string',
            'rol' => 'required|in:Administrador,Empleado,Cliente',
            'status' => 'required|in:Activo,Inactivo,Suspendido',
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);
        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        return view('privado.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('privado.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'address' => 'nullable|string',
            'image' => 'nullable|string',
            'rol' => 'required|in:Administrador,Empleado,Cliente',
            'status' => 'required|in:Activo,Inactivo,Suspendido',
        ]);

        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return redirect()->route('users.show', $user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }
}
