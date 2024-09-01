<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Admin = Admin::all();
        return $Admin;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'nombre' => 'required|string|regex:/^[A-Za-z]+[0-9]{6}$/',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8', // Eliminamos 'confirmed'
        ]);
    
        // Crear una nueva instancia de Admin
        $admin = new Admin();
        $admin->nombre = $validatedData['nombre'];
        $admin->email = $validatedData['email'];
        // Hash de la contraseña antes de guardarla
        $admin->password = bcrypt($validatedData['password']);
    
        // Guardar el nuevo administrador en la base de datos
        $admin->save();
    
        // Devolver una respuesta JSON
        return response()->json([
            'message' => 'Administrador creado con éxito.',
            'admin' => $admin
        ], 201); // 201 indica que el recurso fue creado exitosamente
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Admin = Admin ::find($id);
        return $Admin;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'nombre' => 'required|string|regex:/^[A-Za-z]+[0-9]{6}$/',
            'email' => 'required|string|email|max:255|unique:admins,email,' . $id,
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        // Encontrar el administrador por ID
        $admin = Admin::findOrFail($id);
    
        // Actualizar los datos del administrador
        $admin->nombre = $validatedData['nombre'];
        $admin->email = $validatedData['email'];
        $admin->password = bcrypt($validatedData['password']);
    
        // Guardar los cambios
        $admin->save();
    
        // Devolver el administrador actualizado en la respuesta
        return response()->json([
            'message' => 'Administrador actualizado con éxito.',
            'admin' => $admin
        ], 200);
    }
    
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Admin = Admin::destroy($id);
        return $Admin; 
    }
}
