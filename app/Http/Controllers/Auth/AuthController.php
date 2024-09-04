<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Post(
     *      path="/api/register",
     *      operationId="registerUser",
     *      tags={"Authentication"},
     *      summary="Register a new user",
     *      description="Register a new user with the provided name, email, and password.",
     *      @OA\RequestBody(
     *          required=true,
     *          description="User details",
     *          @OA\JsonContent(
     *              required={"name", "email", "password"},
     *              @OA\Property(property="name", type="string", example="John Doe"),
     *              @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *              @OA\Property(property="password", type="string", example="password"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="User registered successfully",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="user", ref="#/components/schemas/User"),
     *              @OA\Property(property="access_token", type="string"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation errors",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string"),
     *          ),
     *      ),
     * )
     */
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = $this->userService->register($request->all());
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(["user" => $user, "access_token" => $token], Response::HTTP_CREATED);
    }

    /**
     * @OA\Post(
     *      path="/api/login",
     *      operationId="loginUser",
     *      tags={"Authentication"},
     *      summary="Log in an existing user",
     *      description="Log in an existing user with the provided email and password.",
     *      @OA\RequestBody(
     *          required=true,
     *          description="User credentials",
     *          @OA\JsonContent(
     *              required={"email", "password"},
     *              @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *              @OA\Property(property="password", type="string", example="password"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User logged in successfully",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="user", ref="#/components/schemas/User"),
     *              @OA\Property(property="access_token", type="string"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation errors",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string"),
     *          ),
     *      ),
     * )
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = $request->user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['access_token' => $token, 'user' => $user]);
    }

    /**
     * @OA\Post(
     *      path="/api/logout",
     *      operationId="logoutUser",
     *      tags={"Authentication"},
     *      summary="Log out the authenticated user",
     *      description="Log out the authenticated user by revoking the access token.",
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="User logged out successfully",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string"),
     *          ),
     *      ),
     * )
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
