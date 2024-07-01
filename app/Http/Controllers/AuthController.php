<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Support\Exceptions\OAuthException;
use App\Support\Traits\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use Authenticatable;

    function register(Request $request)
    {
        try {
            // Validate form data
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|max:255',
                'password' => 'required|string|max:255',
                'role' => 'string',
                'image' => 'string|max:255',
            ]);
            $data = $request->all();
            $data['password'] = Hash::make($request->input('password'));
            $user = User::create($data);
            return new JsonResponse($user, Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            return response(['message' => 'User not saved'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!$token = Auth::attempt(credentials: $request->credentials())) {
            throw new OAuthException(code: 'invalid_credentials_provided');
        }

        return $this->responseWithToken(access_token: $token);
    }

    /**
     * Refresh a token.
     *
     * @return \App\Modules\Auth\Collections\TokenResource
     */
    public function refresh(): JsonResponse
    {
        return $this->responseWithToken(access_token: auth()->refresh());
    }


    public function showAll()
    {
        try {
            $users = User::all();
            return new JsonResponse(['users' => $users], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return new JsonResponse(['message' => 'Users not found'], Response::HTTP_BAD_REQUEST);
        }
    }


    public function update(Request $request, User $user)
    {
        try {
            // Validate form data
            $request->validate([
                'name' => 'string|max:255',
                'email' => 'string|max:255',
                'password' => 'string|max:255',
                'role' => 'string',
                'image' => 'string|max:255',
            ]);

            $data = $request->all();
            if ($data['password']) {
                $data['password'] = Hash::make($data['password']);
            }
            $user->update($data);

            return new JsonResponse(['user' => $user->refresh()], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response(['message' => 'User not updated'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return new JsonResponse(['success' => true]);
    }


    // PROYECTOS
    
}
