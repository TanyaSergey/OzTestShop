<?php

namespace App\Http\Controllers;

use App\Buy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BuyController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function buy(Request $request) :JsonResponse
    {
        Buy::saveBuy($request);
        return response()->json(['success' => true]);
    }
}