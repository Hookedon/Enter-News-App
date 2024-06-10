<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class ApiNewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $noticias=News::all();
        return response()->json([
            'status' => true,
            'noticias' => $noticias
        ]);
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
        $noticias = News::create($request->all());

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
        $noticias=News::find($id);
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
        $noticia = News::find($id);


        $noticia->titulo=$request->input("titulo");
        $noticia->autor=$request->input("autor");
        $noticia->url=$request->input("url");
        $noticia->veracidad=$request->input("veracidad");
        $noticia->relevancia=$request->input("relevancia");
        $noticia->comunidad=$request->input("comunidad");
        $noticia->fecha_publicacion=$request->input("fecha_publicacion");
        $noticia->sinopsis=$request->input("sinopsis");

        $noticia->save();

        return response()->json([
            'status' => true,
            'message' => "Noticia modificada correctamente!",
            'product' => $noticia
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $noticia= News::find($id);
        $noticia->delete();

        return response()->json([
            'status' => true,
            'message' => "Noticia borrada correctamente!",
            'product' => $noticia
        ], 200);
    }
}
