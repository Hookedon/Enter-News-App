<?php 
namespace App\Http\Controllers;

use App\Models\NoticiasEliminadas;
use App\Models\NoticiasNoConfirmadas;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiNoticiasEliminadasController extends Controller
{

    public function archiveAndDestroy(string $id)
    {
        DB::transaction(function () use ($id) {
            $noticia = NoticiasNoConfirmadas::findOrFail($id);

            $noticiaEliminada = new NoticiasEliminadas();
            $noticiaEliminada->titulo = $noticia->titulo;
            $noticiaEliminada->autor = $noticia->autor;
            $noticiaEliminada->url = $noticia->url;
            $noticiaEliminada->veracidad = $noticia->veracidad;
            $noticiaEliminada->relevancia = $noticia->relevancia;
            $noticiaEliminada->comunidad_id = $noticia->comunidad_id;
            $noticiaEliminada->fecha_publicacion = $noticia->fecha_publicacion;
            $noticiaEliminada->sinopsis = $noticia->sinopsis;
            $noticiaEliminada->save();

            $noticia->delete();
        });

        return response()->json([
            'status' => true,
            'message' => "Noticia archivada y borrada correctamente!"
        ], 200);
    }
}