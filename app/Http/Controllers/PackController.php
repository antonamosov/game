<?php

namespace App\Http\Controllers;

use App\Http\Resources\PackResource;
use App\Models\Pack;
use App\Services\PackService;
use Illuminate\Http\Request;

class PackController extends BaseApiController
{
    public function index(Pack $pack)
    {
        return $this->respond([
            'data' => PackResource::collection($pack->all())
        ]);
    }

    public function buyByCoins(Pack $pack, PackService $packService)
    {
        $packService->buy(getUser(), $pack);

        $error = ! $packService->getSuccess() ? [ 'error' => $packService->getError() ] : [];

        return $this->respond(array_merge([
            'success' => $packService->getSuccess()
        ], $error));
    }
}
