<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Utility\Util;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(RegistrationRequest $request)
    {
        DB::beginTransaction();
        try {
            //Create A business User Account

            $businessUser = new User();
            $businessUser->name = $request->name;
            $businessUser->email = $request->email;
            $businessUser->password =  Hash::make($request->password);
            $businessUser->avatar = User::avatar();
            $businessUser->save();

            DB::commit();
            Auth::login($businessUser);

            $tokenResult = $businessUser->createToken('token_name');
            $token = $tokenResult->plainTextToken;
            $expiration = Carbon::now()->addHour(3);
            $tokenResult->accessToken->expires_at = $expiration;
            $tokenResult->accessToken->save();
            return response()->json(['success'=> true, 'user' => $businessUser,'access_token' => $token,'expires_at' => $expiration, 'message' => 'Account Registered Successfully'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 401);
        }
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'email' =>'required|email',
            'password' => 'required|string'
        ]);

        if(Auth::attempt($validate)){
            $user = Util::Auth();
            if(!$user->email)
            {
                $message = "No account associated with this email address";
            }else{
                $message = "Login successful";
            }

            $tokenResult = $user->createToken('token_name');
            $token = $tokenResult->plainTextToken;
            $expiration = Carbon::now()->addHour(3);
            $tokenResult->accessToken->expires_at = $expiration;
            $tokenResult->accessToken->save();
            $response = response()->json(['success'=> true, 'message' => $message, 'user' => $user,'access_token' => $token,'expires_at' => $expiration
            ], 200);
        }else{
            $response = response()->json(['success' => false,'message' => 'Invalid Login credentials'], 401);
        }

        return $response;

    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        $response = response()->json(['success'=> true,'message' => 'User logged out successfully'], 200);
        return $response;
    }
}
