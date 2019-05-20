<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\SortedProductsRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Products;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() :View
    {
        return view("public.product");
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function accountProduct() :View
    {
        $data = Products::accountProduct();

        return view("account.product.index", [
            'products' => $data['products'],
            'countProducts' => $data['productsCount']
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() :View
    {
        return view("account.product.create");
    }

    /**
     * @param CreateProductRequest $request
     * @return RedirectResponse
     */
    public function saveProduct(CreateProductRequest $request) :RedirectResponse
    {
        Products::createNewProduct($request);
        return redirect('/products');
    }

    /**
     * @param $productId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editProduct(int $productId) :View
    {
        return view("account.product.edit", ['product' => Products::where('product_id', $productId)->first()]);
    }

    /**
     * @param int $productId
     * @param UpdateProductRequest $request
     * @return RedirectResponse
     */
    public function updateProduct(int $productId, UpdateProductRequest $request) :RedirectResponse
    {
        Products::updateProduct($productId, $request);
        return redirect('/products');
    }

    /**
     * @param SortedProductsRequest $request
     * @return JsonResponse
     */
    public function sortedProducts(SortedProductsRequest $request) :JsonResponse
    {
        return response()->json([
            'products' => Products::sortedProducts($request->type, $request->filter)
        ]);
    }

    /**
     * @param Request $request
     * @param $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProduct(Request $request, int $productId) :JsonResponse
    {
        $data = Products::getProduct($request, $productId);
        return response()->json([
            'user' => Auth::user(),
            'product' => $data['product'],
            'productInCart' => $data['checkProductInCart']
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function boughtProduct() :View
    {
        return view("account.product.bought", ['products' => Products::boughtProduct()]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sales() :View
    {
        return view("account.product.sales", ['products' => Products::sales()]);
    }
}