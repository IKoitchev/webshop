<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Http\Resources\EmployeeDetailed as EmployeeResource;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Issues a new authentication token for an employee,
     * assigning it to a particular name.
     *
     * @param  \App\Models\Employee  $user
     * @param  string $device_name
     * @return string
     */
    public static function generateToken(Employee $user, string $name = null)
    {
        return 'Bearer ' . $user->createToken(
            $name ?? request()->header('User-Agent') ?? "Unknown"
        )->plainTextToken;
    }
    /**
     * @OA\Post(
     * path="/api/employees/login",
     * summary="Sign in",
     * description="Login by email, password",
     * operationId="authLogin",
     * tags={"auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345")
     *    ),
     * ),
     * 
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="")
     *        )
     *     )
     * )
     * 
     */
    /**
     * Authenticates an existing user.
     *
     * @param  App\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function login(LoginRequest $request)
    {
        // Identify the user
        $user = Employee::where('email',
          request()->get('email'))->firstOrFail();

        // Validate credentials
        if (!Hash::check($request->get('password'), $user->password))
            throw ValidationException::withMessages([
                'password' => ['The provided credentials are incorrect.'],
            ]);

        // Generate a token
        return response(new EmployeeResource($user))->withHeaders([
            'Authorization' => self::generateToken($user),
        ]);
    }
    /**
     * @OA\Post(
     * path="/api/employees/logout",
     * summary="Log out",
     * description="Log out",
     * operationId="authLogout",
     * tags={"auth"},
     * @OA\RequestBody(
     *    required=false,
     *    description="logout",
     * ),
     * 
     * * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="")
     *        )
     *     ),
     *    security={{"bearer":{}}},
     * )
     * 
     */
    /**
     * Revokes a currently used token from the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
