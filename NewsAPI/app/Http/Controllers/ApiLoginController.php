<?php
namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // Import Log facade

class ApiLoginController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->input('nombre');
        $password = $request->input('contrasenya');
        
        Log::info('Login attempt with username: ' . $username);

        $usuario = Usuarios::where('nombre', $username)->first();

        if ($usuario && Hash::check($password, $usuario->contrasenya)) {
            Log::info('Login successful for user: ' . $username);
            return response()->json([
                'status' => true,
                'user' => $usuario,
            ]);
        } else {
            Log::info('Login failed for user: ' . $username);
            return response()->json([
                'status' => false,
                'message' => 'Invalid username or password',
            ], 401); // Return 401 Unauthorized status for failed login
        }
    }
    public function index(){}
}