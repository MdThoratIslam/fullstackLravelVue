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

            /*$user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password))
            {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }*/

            if (!auth()->attempt($request->only('email', 'password'))) {
//                return response()->json(['message' => 'The provided credentials are incorrect.'], 401);

                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }




        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);

        }
    }
}
