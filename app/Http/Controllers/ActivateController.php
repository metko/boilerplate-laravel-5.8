<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivateController extends Controller
{
    public function show()
    {
        return view('activate.show');
    }

    public function desactivate(Request $request)
    {
        $user = auth()->user()->desactivate()->logout();
        return route('/');
    }
}
