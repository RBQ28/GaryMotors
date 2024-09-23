<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Moto;
use Illuminate\Http\Request;

class MotosController extends Controller
{
    // Obtener todas las motos
    public function index()
    {
        $motos = Moto::all();
        return response()->json($motos);
    }

   // Almacenar una moto
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'modelo' => 'required|string',
            'marca' => 'required|string',
            'categoria' => 'required|string',
            'precio' => 'required|numeric',
            'descripcion' => 'required|string',
            'anio' => 'required|integer',
            'cilindrada' => 'required|numeric',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Guardar la imagen en la carpeta 'public/motos'
        $imagePath = $request->file('imagen')->store('motos', 'public'); // Guardar en public/motos
        $imageName = basename($imagePath);

        // Crear una nueva moto
        $moto = Moto::create([
            'modelo' => $validatedData['modelo'],
            'marca' => $validatedData['marca'],
            'categoria' => $validatedData['categoria'],
            'precio' => $validatedData['precio'],
            'descripcion' => $validatedData['descripcion'],
            'anio' => $validatedData['anio'],
            'cilindrada' => $validatedData['cilindrada'],
            'imagen' => $imageName, // Almacenar solo el nombre de la imagen
        ]);

        return response()->json(['success' => true, 'data' => $moto], 201);
    }

    // Actualizar una moto
    public function update(Request $request, $id)
    {
        $moto = Moto::findOrFail($id);
        
        $validatedData = $request->validate([
            'modelo' => 'sometimes|required|string',
            'marca' => 'sometimes|required|string',
            'categoria' => 'sometimes|required|string',
            'precio' => 'sometimes|required|numeric',
            'descripcion' => 'sometimes|required|string',
            'anio' => 'sometimes|required|integer',
            'cilindrada' => 'sometimes|required|numeric',
            'imagen' => 'nullable|image|max:2048',
        ]);
        
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($moto->imagen) {
                Storage::disk('public')->delete('motos/' . $moto->imagen);
            }
            // Almacenar la nueva imagen
            $rutaImagen = $request->file('imagen')->store('motos', 'public');
            $validatedData['imagen'] = basename($rutaImagen); // Guardar solo el nombre
        }
        
        $moto->update($validatedData);
        return response()->json($moto);
    }


    // Obtener una moto específica
    public function show($id)
    {
        $moto = Moto::findOrFail($id);
        return response()->json($moto);
    }

 
    // Eliminar una moto
    public function destroy($id)
    {
        $moto = Moto::findOrFail($id);
        
        // Eliminar la imagen del sistema de archivos
        if ($moto->imagen) {
            Storage::disk('public')->delete('motos/' . $moto->imagen);
        }

        $moto->delete();
        return response()->json(null, 204);
    }
}
