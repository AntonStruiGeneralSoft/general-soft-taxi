<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Controllers\Controller;
use Mail;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request) {
        $data = $request->validated();
        Mail::send('mail', ['firstName' => $data['firstName'], 'lastName' => $data['lastName'], 'link' => ''], function ($message) {
            $message->to($data['email'], $data['firstName'] . ' ' . $data['lastName']);
            $message->subject('Registration');
        });
        
        return response()->json();#$data, 200);
    }
}
