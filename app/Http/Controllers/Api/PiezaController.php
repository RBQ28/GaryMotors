<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pieza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PiezaController extends Controller
{
    // Mostrar todos los registros
    public function index()
    {
        return Pieza::all();
    }

    // Almacenar un nuevo registro
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'nombre' => 'required|string',
            'tipo_pieza_id' => 'nullable|exists:tipos_piezas,id', // Campo opcional
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'imagen' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048', // Validación para la imagen
        ]);

        // Manejar la imagen si se ha subido
        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/piezas', $imageName); // Guardar en carpeta "PIEZAS"
            $validatedData['imagen'] = $imageName;
        } else {
            $validatedData['imagen'] = null; // Asegurarse de que la imagen sea nullable
        }

        // Crear una nueva instancia de Piezas
        $pieza = Pieza::create($validatedData);

        return response()->json($pieza, 201);
    }

    // Mostrar un registro específico
    public function show($id)
    {
        return Pieza::findOrFail($id);
    }

    // Actualizar un registro específico
    public function update(Request $request, $id)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'nombre' => 'required|string',
            'tipo_pieza_id' => 'nullable|exists:tipos_piezas,id', // Campo opcional
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'imagen' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048', // Validación para la imagen
        ]);

        // Encontrar la pieza por ID
        $pieza = Pieza::findOrFail($id);

        // Manejar la imagen si se ha subido
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen antigua si existe
            if ($pieza->imagen) {
                Storage::delete('public/piezas/' . $pieza->imagen);
            }

            $image = $request->file('imagen');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/piezas', $imageName); // Guardar en carpeta "PIEZAS"
            $validatedData['imagen'] = $imageName;
        } else {
            $validatedData['imagen'] = $pieza->imagen; // Mantener la imagen existente si no se subió una nueva
        }

        // Actualizar los datos de la pieza
        $pieza->update($validatedData);

        return response()->json($pieza, 200);
    }

    // Eliminar un registro específico
    public function destroy($id)
    {
        // Encontrar la pieza por ID
        $pieza = Pieza::findOrFail($id);

        // Eliminar la imagen si existe
        if ($pieza->imagen) {
            Storage::delete('public/piezas/' . $pieza->imagen);
        }

        // Eliminar la pieza
        $pieza->delete();

        return response()->json(['message' => 'Pieza eliminada con éxito.'], 200);
    }
}
