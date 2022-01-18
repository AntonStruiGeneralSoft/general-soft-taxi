<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Controllers\Controller;
use App\Services\API\RegisterService;
use App\Classes\RoleEnum;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request) {
        $data = $request->validated();

        $result = RegisterService::registerUser($data);
        
        /*Mail::send('mail', ['firstName' => $data['firstName'], 'lastName' => $data['lastName'], 'link' => ''], function ($message) use($data){
            $message->to($data['email'], $data['firstName'] . ' ' . $data['lastName']);
            $message->subject('Регистрация');
        });*/

        return $data;#, 200);
    }
}
