<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreController extends BaseApiController
{
    public function _invoke()
    {
        return $this->respond([
            'data' => [
                'user_id' => \Auth::user()->id
            ]
        ]);
    }
}
