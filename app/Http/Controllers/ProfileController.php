<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class ProfileController extends BaseApiController
{
    public function show()
    {
        $user = \Auth::user();

        return $this->respond([
            'data' => new UserResource($user)
        ]);
    }
}
