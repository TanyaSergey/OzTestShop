<?php

namespace App\Http\Controllers;

use App\Products;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class MainPageController
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() :View
    {
        return view("public.mainPage");
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProducts() :JsonResponse
    {
        $data = Products::mainPageProducts();
        return response()->json([
            'products' => $data['products'],
            'productsCount' => $data['productsCount']
        ]);
    }
}
