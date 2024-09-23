<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Asegúrate de importar esto
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
  

    public function index()
    {
        $admins = Admin::all();
        return response()->json($admins);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|regex:/^[A-Za-z]+[0-9]{6}$/',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8',
        ]);
    
        $admin = new Admin();
        $admin->nombre = $validatedData['nombre'];
        $admin->email = $validatedData['email'];
        $admin->password = bcrypt($validatedData['password']);
    
        $admin->save();
    
        return response()->json([
            'message' => 'Administrador creado con éxito.',
            'admin' => $admin
        ], 201);
    }
    
    public function show(string $id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['message' => 'Administrador no encontrado'], 404);
        }

        return response()->json($admin);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|regex:/^[A-Za-z]+[0-9]{6}$/',
            'email' => 'required|string|email|max:255|unique:admins,email,' . $id,
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        $admin = Admin::findOrFail($id);
    
        $admin->nombre = $validatedData['nombre'];
        $admin->email = $validatedData['email'];
        $admin->password = bcrypt($validatedData['password']);
    
        $admin->save();
    
        return response()->json([
            'message' => 'Administrador actualizado con éxito.',
            'admin' => $admin
        ], 200);
    }
    
    public function destroy(string $id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['message' => 'Administrador no encontrado'], 404);
        }

        $admin->delete();

        return response()->json(['message' => 'Administrador eliminado con éxito'], 200);
    }
}
