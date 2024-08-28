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
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Crear una nueva instancia de Admin
        $admin = new Admin();
        $admin->nombre = $validatedData['nombre'];
        $admin->email = $validatedData['email'];
        // Hash de la contraseña antes de guardarla
        $admin->password = bcrypt($validatedData['password']);

        // Guardar el nuevo administrador en la base de datos
        $admin->save();

        // Opcionalmente, puedes redirigir a una página o devolver una respuesta
        return redirect()->route('admin.index')->with('success', 'Administrador creado con éxito.');
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
    public function update(Request $request, string $id)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Encontrar el administrador por ID
        $Admin = Admin::findOrFail($id);

        // Actualizar los campos con los datos validados
        $Admin->nombre = $validatedData['nombre'];
        $Admin->email = $validatedData['email'];

        // Solo actualizar la contraseña si se proporciona una nueva
        if (!empty($validatedData['password'])) {
            $Admin->password = bcrypt($validatedData['password']);
        }

        // Guardar los cambios en la base de datos
        $Admin->save();

        // Opcionalmente, puedes redirigir a una página o devolver una respuesta
        return redirect()->route('Admin.index')->with('success', 'Administrador actualizado con éxito.');
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
