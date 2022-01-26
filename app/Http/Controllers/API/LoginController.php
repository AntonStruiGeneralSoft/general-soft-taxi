<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Auth;
use Validator;

class LoginController extends Controller
{
    private function valid($data) {
        return Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required|string|min:1',
        ]);
    }

    public function __invoke(Request $request) {
        #Redis::command('SADD', ['1', 'b']);
        #$values = Redis::command('SMEMBERS', ['1']);
        #dd($values);
        $data = $request->all();
   
        $validator = self::valid($data);
   
        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()->messages()], 400);   
        }

        if (!$token = auth()->attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'accessToken' => $token,
            #'refreshToken' => $token,
            'tokenType' => 'bearer',
            'expirationTime' => auth()->factory()->getTTL() * 60,
        ], 200);
    }
}
