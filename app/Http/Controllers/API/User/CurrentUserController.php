<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class CurrentUserController extends Controller
{
    public function __invoke(Request $request) {
        return new UserResource($request->user);
    }
}
