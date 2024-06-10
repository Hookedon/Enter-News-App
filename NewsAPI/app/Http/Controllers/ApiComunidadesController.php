<?php

namespace App\Http\Controllers;

use App\Models\Comunidades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiComunidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comunidades = Comunidades::all();
        return response()->json([
            'status' => true,
            'comunidades' => $comunidades
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'nombre_comunidad' => 'required|string|max:255'
        ]);
    
        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }
    
        // Create new community
        $comunidad = new Comunidades();
        $comunidad->nombre_comunidad = $request->input('nombre_comunidad');
        $comunidad->save();
    
        return response()->json([
            'status' => true,
            'message' => 'Comunidad created successfully',
            'comunidad' => $comunidad
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comunidad = Comunidades::find($id);

        if (!$comunidad) {
            return response()->json([
                'status' => false,
                'message' => 'Comunidad not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'comunidad' => $comunidad
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $comunidad = Comunidades::find($id);

        if (!$comunidad) {
            return response()->json([
                'status' => false,
                'message' => 'Comunidad not found'
            ], 404);
        }

        $comunidad->nombre_comunidad = $request->nombre_comunidad;
        $comunidad->save();

        return response()->json([
            'status' => true,
            'message' => 'Comunidad updated successfully',
            'comunidad' => $comunidad
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comunidad = Comunidades::find($id);

        if (!$comunidad) {
            return response()->json([
                'status' => false,
                'message' => 'Comunidad not found'
            ], 404);
        }

        $comunidad->delete();

        return response()->json([
            'status' => true,
            'message' => 'Comunidad deleted successfully'
        ]);
    }
}