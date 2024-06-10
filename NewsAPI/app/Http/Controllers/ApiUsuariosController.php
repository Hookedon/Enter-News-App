<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiUsuariosController extends Controller
{
    public function index()
    {
        $usuarios = Usuarios::all();

        return response()->json([
            'status' => true,
            'usuarios' => $usuarios
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:usuarios|max:100',
            'contrasenya' => 'required|min:8',
            'email' => 'required|email|unique:usuarios|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        $usuario = new Usuarios();
        $usuario->nombre = $request->nombre;
        $usuario->contrasenya = Hash::make($request->contrasenya);
        $usuario->email = $request->email;
        $usuario->save();

        return response()->json([
            'status' => true,
            'message' => 'Usuario creado exitosamente'
        ]);
    }
}