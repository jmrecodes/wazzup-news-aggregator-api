<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
    * @OA\Get(
    *     path="/register",
    *     @OA\Response(response="200", description="Display a listing of projects.")
    * )
    */

    public function register()
    {
        return response()->json(['message' => 'Registered successfully']);
    }
}
