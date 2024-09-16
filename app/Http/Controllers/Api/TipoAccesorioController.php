<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TipoAccesorio;
use Illuminate\Http\Request;


class TipoAccesorioController extends Controller
{
   
    public function index()
    {
        $tipoAccesorios = TipoAccesorio::all();
        return response()->json($tipoAccesorios);
    }

    
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
        ]);

        $tipoAccesorios = TipoAccesorio::create($validateData);

        return response()->json($tipoAccesorios, 201);
    }

    
    public function show($id)
    {
        $tipoAccesorios = TipoAccesorio::findOrFail($id);
        return response()->json($tipoAccesorios);
    }

    
    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
        ]);

        $tipoAccesorios = TipoAccesorio::findOrFail($id);
        $tipoAccesorios->update($validateData);
        
        return response()->json($tipoAccesorios);
    }

   
    public function destroy( $id)
    {
       $tipoAccesorios = TipoAccesorio::findOrFail($id);
       $tipoAccesorios->delete();

       return response()->json(null, 204);
    }
}
