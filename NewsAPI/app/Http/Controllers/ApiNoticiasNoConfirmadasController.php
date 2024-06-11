<?php

namespace App\Http\Controllers;

use App\Models\NoticiasNoConfirmadas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiNoticiasNoConfirmadasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $noticias = NoticiasNoConfirmadas::all();
        return response()->json([
            'status' => true,
            'noticias' => $noticias
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'comunidad_id' => 'required|integer|exists:comunidades,id',
            'veracidad' => 'required|integer|min:1|max:4',
            'relevancia' => 'required|integer|min:1|max:4', 
            'fecha_publicacion' => 'required|date',
            'sinopsis' => 'nullable|string'
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Create new noticia
        $noticias = NoticiasNoConfirmadas::create($request->all());

        return response()->json([
            'status' => true,
            'message' => "Noticia creada correctamente!",
            'noticias' => $noticias
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $noticia = NoticiasNoConfirmadas::find($id);
        if (!$noticia) {
            return response()->json([
                'status' => false,
                'message' => 'Noticia not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'noticia' => $noticia
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $noticia = NoticiasNoConfirmadas::find($id);
        if (!$noticia) {
            return response()->json([
                'status' => false,
                'message' => 'Noticia not found'
            ], 404);
        }

        // Validate the input
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'comunidad_id' => 'required|integer|exists:comunidades,id',
            'veracidad' => 'required|integer|min:1|max:4',
            'relevancia' => 'required|integer|min:1|max:4',
            'fecha_publicacion' => 'required|date',
            'sinopsis' => 'nullable|string'
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update noticia
        $noticia->update($request->all());

        return response()->json([
            'status' => true,
            'message' => "Noticia updated successfully!",
            'noticia' => $noticia
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $noticia = NoticiasNoConfirmadas::find($id);
        if (!$noticia) {
            return response()->json([
                'status' => false,
                'message' => 'Noticia not found'
            ], 404);
        }

        $noticia->delete();

        return response()->json([
            'status' => true,
            'message' => "Noticia borrada correctamente!",
            'noticia' => $noticia
        ], 200);
    }
}
