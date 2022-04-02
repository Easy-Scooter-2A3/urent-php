<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Test extends Controller
{
    public function index(Request $request)
    {
        $uri = $request->path();
        $h = $request->header('Content-Type');
        // echo("<pre>");
        // print_r($request->headers);
        // echo("</pre>");
        // echo $uri;
        return view('index');
    }
}
