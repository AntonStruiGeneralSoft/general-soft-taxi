<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\API\RegisterRequest;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request) {
        $data = $request->validated();
    }
}
