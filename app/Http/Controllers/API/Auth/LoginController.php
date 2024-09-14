<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            // Fetch the user by username
            $user = User::where('username', $request->username)->first();

            // Check if the user exists and the password is correct
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Invalid credentials'
                ], 401);
            }

            // Check if the user is a doctor
            if ($user->type !== "doctor") {
                return response()->json([
                    'message' => "Only for doctor's login"
                ], 403);
            }

            // Generate the token
            $token = $user->createToken('pmd')->plainTextToken;

            // Return success response with the token
            return response()->json([
                'status' => 'success',
                'message' => 'You have logged in successfully',
                'access_token' => $token,
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => "Couldn't log in. Please try again.",
                'data' => []
            ], 500); // Use 500 for server errors
        }
    }
}
