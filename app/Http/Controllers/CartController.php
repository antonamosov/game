<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartRequest;

class CartController extends BaseApiController
{
    public function store(StoreCartRequest $request)
    {
        $cart = getUser()->Carts()->create([
            'data' => $request->cart
        ]);

        return $this->respond([
            'data' => [
                'id' => $cart->id
            ]
        ]);
    }
}
