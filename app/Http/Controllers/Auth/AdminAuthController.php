<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    // Registro de Admin
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|unique:admins',
            'email' => 'required|string|email|unique:admins',
            'password' => 'required|string|min:6',
        ]);

        $admin = Admin::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Admin creado con éxito', 'admin' => $admin], 201);
    }

    // Login de Admin
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $admin = Admin::where('email', $request->email)->first();
    
        if ($admin && Hash::check($request->password, $admin->password)) {
            return response()->json(['message' => 'Inicio de sesión exitoso']);
        }
    
        return response()->json(['message' => 'Credenciales incorrectas'], 401);
    }
    
}
