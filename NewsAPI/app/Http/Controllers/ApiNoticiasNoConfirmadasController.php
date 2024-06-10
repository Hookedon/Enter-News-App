<?php

namespace App\Http\Controllers;

use App\Models\NoticiasNoConfirmadas;
use Illuminate\Http\Request;

class ApiNoticiasNoConfirmadasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comunidades=NoticiasNoConfirmadas::all();
        return response()->json([
            'status' => true,
            'comunidades' => $comunidades
        ]);//OJO//
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        $noticias=NoticiasNoConfirmadas::find($id);
        return response()->json([
            'status' => true,
            'noticias' => $noticias
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $noticia= NoticiasNoConfirmadas::find($id);
        $noticia->delete();

        return response()->json([
            'status' => true,
            'message' => "Noticia borrada correctamente!",
            'product' => $noticia
        ], 200);
    }
}
