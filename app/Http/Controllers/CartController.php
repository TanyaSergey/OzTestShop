<?php

 namespace App\Http\Controllers;

 use App\Services\CartService;
 use Illuminate\Contracts\View\View;
 use Illuminate\Http\JsonResponse;
 use Illuminate\Http\RedirectResponse;
 use Illuminate\Http\Request;

 class CartController
 {
     /**
      * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
      */
     public function index() :View
     {
         return view("public.cart");
     }

     /**
      * @param Request $request
      * @param CartService $cartService
      * @return JsonResponse
      */
     public function add(Request $request, CartService $cartService) :JsonResponse
     {
         $cartService->addProductInCart($request);
         return response()->json();
     }

     /**
      * @param Request $request
      * @param CartService $cartService
      * @return JsonResponse
      */
     public function getCart(CartService $cartService, Request $request) :JsonResponse
     {
         return response()->json([
             'products' => $cartService->getCartWithProduct($request)
         ]);
     }

     /**
      * @param Request $request
      * @param $productId
      * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
      */
     public function delete(Request $request, int $productId) :RedirectResponse
     {
         $productsInCart = $request->session()->get("cartProductId");
         $productsInCart = $productsInCart ? json_decode($productsInCart, 1) : [];
         $result = [];
         foreach ($productsInCart as $item) {
             if ($item['id'] != $productId){
                 $result[] = $item;
             }
         }
         $request->session()->put("cartProductId", json_encode($result));
         return redirect('/cart');
     }
 }