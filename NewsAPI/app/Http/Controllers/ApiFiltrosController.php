<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class ApiFiltrosController extends Controller
{
    public function index(Request $request)
    {
        // Obtener parámetros de filtro de la solicitud
        $comunidad = $request->query('comunidad_id');
        $veracidad = $request->query('veracidad');
        $relevancia = $request->query('relevancia');
        
        // Aplicar filtros a los datos
        $data = News::where('comunidad_id', $comunidad)
                    ->where('veracidad', '>=', $veracidad)
                    ->where('relevancia', '>=', $relevancia)
                    ->get();

        // Devolver los resultados
        return response()->json($data);
    }
}