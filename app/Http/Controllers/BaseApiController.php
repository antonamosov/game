<?php

namespace App\Http\Controllers;

class BaseApiController extends Controller
{
    protected function respond($data, $statusCode = 200)
    {
        return response()->json($data, $statusCode);
    }
}
