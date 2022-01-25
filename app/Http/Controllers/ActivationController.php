<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ActivationController extends Controller
{
    public function __invoke($link) {
        $user = User::where('activationLink', '=', $link)
                        ->first();

        if ($user && $user->email_verified_at === null) {
            $user->email_verified_at = now();
            $user->save();
            return view('activation');
        }

        abort(404);
    }
}
