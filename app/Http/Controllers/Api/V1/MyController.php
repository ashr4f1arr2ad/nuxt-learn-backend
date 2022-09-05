<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyController extends Controller
{
    public function store(Request $request) {

        //get request from header like ..../check?message=dfasdlfsdf
        // $mes = request('message');
        // return $mes;

        //check which method are sending get or post or something
        // return $request->method();

        //check the path of route like api/check
        return $request->path();

        //check the url of following route provides
        return $request->url();
    }
}
