<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends BaseApiController
{
    public function index(Product $product)
    {
        return $this->respond([
            'data' => ProductResource::collection($product->all())
        ]);
    }
}
