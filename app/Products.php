<?php

namespace App;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Products extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const STATUS_DELETED = 3;

    /**
     * @param CreateProductRequest $request
     * @return Products
     */
    public static function createNewProduct(CreateProductRequest $request) :Products
    {
        $fileName = null;
        $image = $request->file('image');
        if ($image){
            $fileName = $image->getClientOriginalName();
            $fileName = md5($fileName . microtime()). "." .$image->getClientOriginalExtension();
            $image->move(public_path()."/imagies/product",  $fileName);
        }
        $product = new Products();
        $product->user_id = Auth::user()->id;
        $product->title = trim($request->title);
        $product->price = $request->price;
        $product->description = trim($request->description);
        $product->quantity = $request->quantity;
        $product->image = $fileName;
        $product->status = Products::STATUS_ACTIVE;
        $product->save();
        return $product;
    }

    /**
     * @return array
     */
    public static function mainPageProducts() :array
    {
        $products = Products::where('status', Products::STATUS_ACTIVE)
            ->where('quantity', '>', 0)
            ->orderBy('created_at', 'desc')
            ->get();
        return ['products' => $products, 'productsCount' => $products->count()];
    }

    /**
     * @return array
     */
    public static function accountProduct() :array
    {
        $user = Auth::user();
        $products = Products::where('user_id', $user->id)
            ->where('status', '!=', Products::STATUS_DELETED)
            ->where('quantity', '>', 0)
            ->get();
        return ['products' => $products, 'productsCount' => $products->count()];
    }

    /**
     * @param int $productId
     * @param UpdateProductRequest $request
     * @return bool
     */
    public static function updateProduct(int $productId, UpdateProductRequest $request) :bool
    {
        $product = Products::where('product_id', $productId)
            ->update(['title' => $request->title, 'description' => $request->description, 'quantity' => intval($request->quantity), 'price' => $request->price, 'status' => $request->status]);
        return $product;
    }

    /**
     * @param string $type
     * @param string $filter
     * @return Collection
     */
    public static function sortedProducts(string $type, string $filter = 'desc') :Collection
    {
        $products = Products::where('quantity', '>', 0)
            ->where('status', Products::STATUS_ACTIVE);
        if ($type == 'product') {
            $products = $products->where('title', 'LIKE', '%' . $filter . '%');
        } elseif ($type !== 'product') {
            $products = $products->orderBy( $type, $filter);
        }
        $products = $products->get();
        return $products;
    }

    /**
     * @param Request $request
     * @param int $productId
     * @return array
     */
    public static function getProduct(Request $request, int $productId) :array
    {
        $checkProductInCart = false;
        $cartProductId = $request->session()->get("cartProductId");
        if (!empty($cartProductId)) {
            $productsInCart = json_decode($cartProductId, 1);
            foreach ($productsInCart as $productInCart) {
                if ($productInCart['id'] == $productId) {
                    $checkProductInCart = true;
                    break;
                }
            }
        }
        $product = Products::where('product_id', $productId)->first();

        return ['product' => $product, 'checkProductInCart' => $checkProductInCart];
    }

    /**
     * @param int $productId
     * @param int $quantitySold
     * @return bool
     */
    public static function updateQuantity(int $productId, int $quantitySold) :bool
    {
        $product = Products::where('product_id', $productId)->first();
        $quantityProduct = $product->quantity;
        $residualProducts = $quantityProduct - $quantitySold;
        if($residualProducts == 0) {
            Products::where('product_id', $productId)->update(['status' => Products::STATUS_DELETED]);
        }
        Products::where('product_id', $productId)->update(['quantity' => $residualProducts]);

        return true;
    }

    /**
     * @return array
     */
    public static function boughtProduct() :array
    {
        $boughtProducts = Buy::where('customer_id', Auth::user()->id)->get();
        if($boughtProducts->count() == 0) {
            return [];
        }
        foreach ($boughtProducts as $boughtProduct){
            $product = Products::where('product_id', $boughtProduct->product_id)->first();
            $product->boughtQuantity = $boughtProduct->quantity;
            $product->timeBuy = $boughtProduct->created_at;
            $product->user = User::where('id', $boughtProduct->seller_id)->first();
            $dataProducts[] = $product;

        }
        return $dataProducts;
    }

    /**
     * @return array
     */
    public static function sales() :array
    {
        $salesProducts = Buy::where('seller_id', Auth::user()->id)->get();
        if($salesProducts->count() == 0) {
            return [];
        }
        foreach ($salesProducts as $salesProduct){
            $product = Products::where('product_id', $salesProduct->product_id)->first();
            $product->boughtQuantity = $salesProduct->quantity;
            $product->timeBuy = $salesProduct->created_at;
            $product->user = User::where('id', $salesProduct->customer_id)->first();
            $dataProducts[] = $product;

        }
        return $dataProducts;
    }
}