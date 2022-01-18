<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request) {
        $data = $request->validated();
        return response()->json($data, 200);
    }
}
