<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\Else_;

class userAuth extends Controller
{
    private $signUpRules = [
        'username' => 'required|string',
        'email' => 'required|unique:users,email',
        'password' => 'required|min:8'
    ];
    private $signInRules = [
        'email' => 'required|email|exists:users',
        'password' => 'required|min:8'
    ];
    private $customMessages = [
        'required' => 'Cannot be empty',
        'string' => 'Please use alphabet letters',
        'min' => 'Password must have a minimum 8 characters',
    ];
    public function registerUser(Request $userData)
    {

        $validatedInput = Validator::make($userData->all(), $this->signUpRules, $this->customMessages);

        if ($validatedInput->fails()) {
            $errors = $validatedInput->errors()->toArray();
            return response()->json([
                'status' => 400,
                'success' => false,
                'data' => [
                    'message' => $errors
                ]
            ], 400);
        } else {
            $newUser = users::create([
                'username' => $userData->username,
                'email' => $userData->email,
                'password' => Hash::make($userData->password),
            ]);

            if ($newUser) {
                return response()->json([
                    'status' => 200,
                    'success' => true,
                    'data' => [
                        'user' => [
                            'username' => $userData->username,
                            'email' => $userData->email,
                        ]
                    ]
                ], 200);
            } else {
                return response()->json([
                    'status' => 400,
                    'success' => false,
                    'data' => [
                        'message' => 'User could not be created'
                    ]
                ], 400);
            }
        }
    }
    public function signInUser(Request $userData)
    {

        $user = users::where('email', '=', $userData->email)->first();
        if ($user) {
            $passValidated = Hash::check($userData->password, $user->password);
            if ($passValidated) {
                return response()->json([
                    'status' => 200,
                    'success' => true,
                    'data' => [
                        'user' => [
                            'username' => $user->username,
                            'email' => $userData->email,
                        ]
                    ]
                ], 200);
            } else {
                return response()->json([
                    'status' => 400,
                    'success' => false,
                    'data' => [
                        'message' => "Wrong password!"
                    ]
                ], 400);
            }
        } else {
            return response()->json([
                'status' => 400,
                'success' => false,
                'data' => [
                    'message' => "User not found! Please confirm your email."
                ]
            ], 400);
        }
    }
}
