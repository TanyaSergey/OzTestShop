<?php

namespace App\Services;

use App\Products;
use App\User;
use Illuminate\Http\Request;

class CartService
{

    /**
     * @param Request $request
     * @return bool
     */
    public function addProductInCart(Request $request) :bool
    {
        $productsInCart = $request->session()->get("cartProductId");
        $productsInCart = $productsInCart ? json_decode($productsInCart, 1) : [];
        $productsInCart[] = ['id' => $request->selectProduct, 'quantity' => 1];
        $request->session()->put("cartProductId", json_encode($productsInCart));

        return true;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getCartWithProduct(Request $request)
    {
        $products = [];
        $productsInCart = $request->session()->get("cartProductId");
        $productsInCart = $productsInCart ? json_decode($productsInCart, 1) : [];
        if (!empty($productsInCart)) {
            $productIds = [];
            foreach ($productsInCart as $item) {
                $productIds[] = $item['id'];
            }
            $products = Products::whereIn('product_id', $productIds)->get();
            foreach ($products as $product){
                foreach ($productsInCart as $cartItem) {
                    if ($cartItem['id'] == $product->product_id) {
                        $product->user_data = User::where('id', $product->user_id)->first();
                        $product->quantityInCart = $cartItem['quantity'];
                    }
                }
            }
        }
        return $products;
    }
}