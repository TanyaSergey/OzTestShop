<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Buy extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'buy';

    /**
     * @param Request $request
     * @return bool
     */
    public static function saveBuy(Request $request) :bool
    {
        foreach ($request->products as $product){
            $buy = new Buy();
            $buy->customer_id = Auth::user()->id;
            $buy->seller_id = $product['user_id'];
            $buy->product_id = $product['product_id'];
            $buy->quantity = $product['quantityInCart'];
            $buy->save();
            Products::updateQuantity($product['product_id'], $product['quantityInCart']);
            $request->session()->put("cartProductId", json_encode([]));
        }
        return true;
    }


}
