<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TipoPieza;
use Illuminate\Http\Request;

class TipoPiezaController extends Controller
{
    public function index()
    {
        $tiposPiezas = TipoPieza::all();
        return response()->json($tiposPiezas);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
        ]);

        $tipoPieza = TipoPieza::create($validatedData);

        return response()->json($tipoPieza, 201);
    }

    public function show($id)
    {
        $tipoPieza = TipoPieza::findOrFail($id);
        return response()->json($tipoPieza);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
        ]);

        $tipoPieza = TipoPieza::findOrFail($id);
        $tipoPieza->update($validatedData);

        return response()->json($tipoPieza);
    }

    public function destroy($id)
    {
        $tipoPieza = TipoPieza::findOrFail($id);
        $tipoPieza->delete();

        return response()->json(null, 204);
    }
}
