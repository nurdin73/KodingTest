<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/login",
     *      operationId="Login",
     *      tags={"Auth"},
     *      summary="Login to app",
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if($user = Auth::attempt($data)) {
            return response()->json([
                'message' => 'Login successful',
                'token' => Auth::user()->createToken('MyApp')->plainTextToken,
                'type' => 'Bearer',
            ], 200);
        }
        return response()->json(['message' => 'Login failed'], 401);
    }
}
