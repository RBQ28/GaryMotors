<?php

namespace App\Http\Controllers\Api;

use App\Models\Accesorio;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AccesorioController extends Controller
{
    // Mostrar todos los registros
    public function index()
    {
        return response()->json(Accesorio::all());
    }

    // Almacenar un nuevo registro
    public function store(Request $request)
    {
         // Validar los datos de entrada
         $validatedData = $request->validate([
            'nombre' => 'required|string',
            'tipo_accesorio_id' => 'required|exists:tipo_accesorios,id',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'imagen' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048', // Validación para la imagen
        ]);

        // Manejar la imagen si se ha subido
        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $validatedData['imagen'] = $imageName;
        }

        // Crear una nueva instancia de Accesorio   
        $accesorio  = Accesorio::create($validatedData);

        return response()->json($accesorio , 201);
    }

    // Mostrar un registro específico
    public function show(string $id)
    {
        return Accesorio::findOrFail($id);
    }

    // Actualizar un registro específico
    public function update(Request $request, string $id)
    {
       // Validar los datos de entrada
       $validatedData = $request->validate([
        'nombre' => 'required|string',
        'tipo_accesorio_id' => 'required|exists:tipo_accesorios,id',
        'descripcion' => 'required|string',
        'precio' => 'required|numeric',
        'stock' => 'required|integer',
        'imagen' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048', // Validación para la imagen
    ]);

    // Encontrar la pieza por ID
    $accesorio  = Accesorio::findOrFail($id);

    // Manejar la imagen si se ha subido
    if ($request->hasFile('imagen')) {
        // Eliminar la imagen antigua si existe
        if ($accesorio ->imagen) {
            Storage::delete('public/images/' . $accesorio ->imagen);
        }

        $image = $request->file('imagen');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/images', $imageName);
        $validatedData['imagen'] = $imageName;
    }

     // Actualizar los datos de la pieza
     $accesorio ->update($validatedData);

     return response()->json($accesorio );

    }

     // Eliminar un registro específico
     public function destroy($id)
     {
         // Encontrar la Accesorio por ID
         $accesorio  = Accesorio::findOrFail($id);
 
         // Eliminar la imagen si existe
         if ($accesorio ->imagen) {
             Storage::delete('public/images/' . $accesorio ->imagen);
         }
 
         // Eliminar la Accesorio
         $accesorio ->delete();
 
         return response()->json(['message' => 'Accesorio eliminada con éxito.'], 200);
     }
}
