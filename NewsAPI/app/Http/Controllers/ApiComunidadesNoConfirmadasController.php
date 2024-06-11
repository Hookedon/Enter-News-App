<?php

namespace App\Http\Controllers;

use App\Models\ComunidadesNoConfirmadas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiComunidadesNoConfirmadasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comunidades = ComunidadesNoConfirmadas::all();
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
            'nombre_comunidad' => 'required|string|max:255',
            'usuario' => 'required|string|max:255',
            'razon' => 'nullable|string',
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Create new comunidad no aceptada
        $comunidad = ComunidadesNoConfirmadas::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Comunidad no aceptada created successfully',
            'comunidad' => $comunidad
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comunidad = ComunidadesNoConfirmadas::find($id);

        if (!$comunidad) {
            return response()->json([
                'status' => false,
                'message' => 'Comunidad no aceptada not found'
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
        $comunidad = ComunidadesNoConfirmadas::find($id);

        if (!$comunidad) {
            return response()->json([
                'status' => false,
                'message' => 'Comunidad no aceptada not found'
            ], 404);
        }

        // Validate the input
        $validator = Validator::make($request->all(), [
            'nombre_comunidad' => 'required|string|max:255',
            'usuario' => 'required|string|max:255',
            'razon' => 'nullable|string',
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update the comunidad
        $comunidad->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Comunidad no aceptada updated successfully',
            'comunidad' => $comunidad
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comunidad = ComunidadesNoConfirmadas::find($id);

        if (!$comunidad) {
            return response()->json([
                'status' => false,
                'message' => 'Comunidad no aceptada not found'
            ], 404);
        }

        $comunidad->delete();

        return response()->json([
            'status' => true,
            'message' => 'Comunidad no aceptada deleted successfully'
        ]);
    }
}
