<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RefreshController extends Controller
{
    public function __invoke(Request $request) {
        dd(11111);
    }
}
