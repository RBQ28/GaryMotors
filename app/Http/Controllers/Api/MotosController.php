<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Moto; // Usa el modelo Moto
use Illuminate\Http\Request;

class MotosController extends Controller
{
    // Obtener todas las motos
    public function index()
    {
        $motos = Moto::all(); // Usa el modelo Moto
        return response()->json($motos);
    }

    // Crear una nueva moto
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'modelo' => 'required|string',
            'marca' => 'required|string',
            'categoria' => 'required|string',
            'precio' => 'required|numeric',
            'descripcion' => 'required|string',
            'anio' => 'required|integer',
            'cilindrada' => 'required|numeric',
            'imagen' => 'nullable|string', // Validación para la imagen
        ]);

        $moto = Moto::create($validatedData); // Usa el modelo Moto
        return response()->json($moto, 201);
    }

    // Obtener una moto específica
    public function show($id)
    {
        $moto = Moto::findOrFail($id); // Usa el modelo Moto
        return response()->json($moto);
    }

    // Actualizar una moto
    public function update(Request $request, $id)
    {
        $moto = Moto::findOrFail($id); // Usa el modelo Moto

        $validatedData = $request->validate([
            'modelo' => 'sometimes|required|string',
            'marca' => 'sometimes|required|string',
            'categoria' => 'sometimes|required|string',
            'precio' => 'sometimes|required|numeric',
            'descripcion' => 'sometimes|required|string',
            'anio' => 'sometimes|required|integer',
            'cilindrada' => 'sometimes|required|numeric',
            'imagen' => 'nullable|string', // Validación para la imagen
        ]);

        $moto->update($validatedData); // Usa el modelo Moto
        return response()->json($moto);
    }

    // Eliminar una moto
    public function destroy($id)
    {
        $moto = Moto::findOrFail($id); // Usa el modelo Moto
        $moto->delete();
        return response()->json(null, 204);
    }
}
