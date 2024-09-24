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

    public function store(Request $request)
    {
        try {
            // Validar los datos de entrada
            $validatedData = $request->validate([
                'modelo' => 'required|string|max:255',
                'marca' => 'required|string|max:255',
                'categoria' => 'required|string|max:255',
                'precio' => 'required|numeric',
                'anio' => 'required|integer',
                'cilindrada' => 'required|integer',
                'descripcion' => 'nullable|string|max:255', // La descripción es opcional
                'imagen' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048', // Validación para la imagen
            ]);
    
            // Manejar la imagen si se ha subido
            if ($request->hasFile('imagen')) {
                $image = $request->file('imagen');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/motos', $imageName); // Almacenar en la carpeta "motos"
                $validatedData['imagen'] = $imageName; // Asignar el nombre de la imagen a los datos validados
            }
    
            // Crear una nueva instancia de Moto
            $moto = Moto::create($validatedData);
    
            return response()->json($moto, 201);
        } catch (\Exception $e) {
            // Capturar cualquier excepción y devolver un mensaje de error
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    

    
// Actualizar una moto
public function update(Request $request, $id)
{
    $moto = Moto::findOrFail($id);
    
    // Validar los datos (la imagen es opcional)
    $validatedData = $request->validate([
        'modelo' => 'sometimes|required|string',
        'marca' => 'sometimes|required|string',
        'categoria' => 'sometimes|required|string',
        'precio' => 'sometimes|required|numeric',
        'descripcion' => 'sometimes|required|string',
        'anio' => 'sometimes|required|integer',
        'cilindrada' => 'sometimes|required|numeric',
        'imagen' => 'nullable|image|max:2048', // Imagen opcional
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
    
    // Actualizar la moto con los datos validados
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
