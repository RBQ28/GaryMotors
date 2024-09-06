<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FormularioContacto;
use Illuminate\Http\Request;

class FormularioContactoController extends Controller
{
    public function index()
    {
        return FormularioContacto::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string',
            'email' => 'required|string|email',
            'telefono' => 'required|string',
            'asunto' => 'required|string',
            'mensaje' => 'required|string',
        ]);

        $contacto = FormularioContacto::create($validatedData);
        return response()->json($contacto, 201);
    }

    public function show($id)
    {
        $contacto = FormularioContacto::findOrFail($id);
        return response()->json($contacto);
    }

    public function update(Request $request, $id)
    {
        $contacto = FormularioContacto::findOrFail($id);

        $validatedData = $request->validate([
            'nombre' => 'sometimes|required|string',
            'email' => 'sometimes|required|string|email',
            'telefono' => 'sometimes|required|string',
            'asunto' => 'sometimes|required|string',
            'mensaje' => 'sometimes|required|string',
        ]);

        $contacto->update($validatedData);
        return response()->json($contacto);
    }

    public function destroy($id)
    {
        $contacto = FormularioContacto::findOrFail($id);
        $contacto->delete();
        return response()->json(null, 204);
    }
}
