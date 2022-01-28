<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Services\API\LoginService;
use App\Models\User;
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
        $data = $request->all();
   
        $validator = self::valid($data);
   
        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()->messages()], 400);   
        }

        $user = User::where('email', '=', $data['email'])->first();

        if (is_null($user)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (!Hash::check($data['password'] , $user->password)) {
            return response()->json(['error' => 'Wrong password'], 400);
        }

        $result = LoginService::login($user);

        return response()->json($result, 200);
    }
}
