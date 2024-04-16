<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{


/**
 * @OA\Post(
 *     path="/api/register",
 *     summary="Create a new user",
 *     @OA\RequestBody(
 *         required=true,
 *         description="User data",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="name",
 *                     type="string",
 *                     example="John Doe"
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     type="string",
 *                     format="email",
 *                     example="john@example.com"
 *                 ),
 *                 @OA\Property(
 *                     property="password",
 *                     type="string",
 *                     format="password",
 *                     example="password123"
 *                 ),
*  *                 @OA\Property(
 *                     property="password_confirmation",
 *                     type="string",
 *                     format="password",
 *                     example="password123"
 *                 ),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User created successfully"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error"
 *     )
 * )
 */

    //request oluşturmadan , unique sorgu

    public function register(Request $request){
        $data = $request->validate([
            'name'=>'required|string',
            'email'=>'required|string|unique:users,email',
            'password'=>'required|string|confirmed'
        ]);

        $user = User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>bcrypt($data['password'])
        ]);

        $token = $user->createToken('utoken')->plainTextToken;

        $response = [
            'user'=> $user,
            'token'=>$token
        ];

        //201 for create

        return response($response,201);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Authenticate user and generate token",
     *     @OA\RequestBody(
     *         required=true,
     *         description="User credentials",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="john@example.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     format="password",
     *                     example="password123"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials"
     *     )
     * )
     */

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Kullanıcı Adı - Şifre Hatalı'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

}
