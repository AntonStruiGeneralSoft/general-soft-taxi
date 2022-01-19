<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Controllers\Controller;
use App\Services\API\RegisterService;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request) {
        $data = $request->validated();

        $result = RegisterService::registerUser($data);

        return [
            'msg' => $result
        ];
    }
}
