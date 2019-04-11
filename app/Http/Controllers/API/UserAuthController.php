<?php

namespace App\Http\Controllers\API;

use App\Helpers\Error;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserAuthController extends Controller{

    /**
     * Checks the given login credentials and returns the
     * users access token on success
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function login(Request $request){
        if (Auth::attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ])) {
            $currentUser = Auth::user();
            $token = $currentUser->createToken('api-token')->accessToken;
            return response([
                'error' => false,
                'token' => $token
            ], 200);
        }
        return response(Error::new("Invalid Login or password."), 403);
    }

    /**
     * Endpoint to register a new user to the system
     * @param Request $request
     * @return array
     */
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|between:5,32'
        ]);

        // If valdiation fails respond with an error object
        if ($validator->fails()) {
            return response(Error::new($validator->getMessageBag()->toArray()), 400);
        }

        $data = $request->all();
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Returns information about the current user
     */
    public function getCurrentUser(){
        return Auth::user();
    }
}
