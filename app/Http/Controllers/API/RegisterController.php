<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\API\RegisterService;
use App\Classes\RoleEnum;
use Illuminate\Validation\Rule;
use Validator;

class RegisterController extends Controller
{
    private function valid($data) {
        return Validator::make($data, [
            'email' => 'required|email|unique:App\Models\User,email',
            'password' => 'required|string|min:1',
            'firstName' => 'required|string|min:1|max:255',
            'lastName' => 'required|string|min:1|max:255',
            'role' => ['required', Rule::in([RoleEnum::CLIENT, RoleEnum::DRIVER])],
            'car.make' => 'nullable|string|min:1',
            'car.model' => 'nullable|string|min:1',
            'car.year' => 'nullable|integer|min:1980|max:' . date('Y'),
            'car.color' => 'nullable|string|min:1',
        ]);
    }

    public function __invoke(Request $request) {
        $data = $request->all();
   
        $validator = self::valid($data);
   
        if ($validator->fails()){
            return response()->json(['success' => false], 400);   
        }

        $result = RegisterService::registerUser($data);

        return response()->json(['success' => $result], $result ? 200 : 400);
    }
}
