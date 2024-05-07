<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)
    {
        try {
            $data = User::create($request->getSanitizedData());
            //$token = $data->createToken('auth_token')->plainTextToken;
            return response()->json([
                'message' => 'User created successfully',
                'status' => 'success',
                //'token' => $token,
                'data' => $data
            ], 201);
        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error'
            ],
                500);
        }
    }
}
