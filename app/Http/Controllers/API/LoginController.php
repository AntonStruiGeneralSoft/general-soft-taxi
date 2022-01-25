<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth; 
use Laravel\Passport\Client as OClient;

class LoginController extends Controller
{
    public function __invoke() {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $oClient = OClient::where('password_client', 1)->first();
            $response = Http::asForm()->post(env('APP_URL', 'http://localhost') . '/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => $oClient->id,
                    'client_secret' => $oClient->secret,
                    'username' => request('email'),
                    'password' => request('password'),
                    'scope' => '*',
                ],
            ]);
    
            $result = json_decode((string) $response->getBody(), true);
            return response()->json($result, $this->successStatus);
        } 
        else { 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }
}
