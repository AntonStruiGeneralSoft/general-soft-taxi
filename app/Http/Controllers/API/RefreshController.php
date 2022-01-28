<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\JWT\TokenService;
use Validator;

class RefreshController extends Controller
{
    private function valid($data) {
        return Validator::make($data, [
            'refreshToken' => 'required|string'
        ]);
    }

    public function __invoke(Request $request) {
        $data = $request->all();
   
        $validator = self::valid($data);
   
        if ($validator->fails()){
            return response()->json(['error' => $validator->errors()->messages()], 400);   
        }

        $result = TokenService::isValid($data['refreshToken']);

        if ($result) {
            #$i = Redis::command('SISMEMBER', [(string)$user->id, $refreshToken]);
            #sismember key_stooges "Harpo"
        } 
    }
}
