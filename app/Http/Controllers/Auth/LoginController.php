<?php
namespace App\Http\Controllers\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        try {
            // Attempt to authenticate the user
            if (!auth()->attempt($request->only('email', 'password'))) {
                // Return error response if authentication fails
                return response()->json(['message' => 'Invalid login details'], 401);
            }
            // Retrieve the authenticated user
            $user = auth()->user();
            $token = $user->createToken('auth_token')->plainTextToken;
            // Return success response with user details and token
            return response()->json([
                'message' => 'User logged in successfully',
                'user' => $user,
                'token' => $token
            ], 200);
        } catch (\Exception $e)

        {
            // Return error response if an exception occurs
            return response()->json([
                'message' => $e->getMessage(),
                'error' => 'Failed to login'
            ], 500);
        }
    }

}
