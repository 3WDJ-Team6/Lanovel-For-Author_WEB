<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartOfIllustration extends Model
{
    protected $table = 'cart_of_illustrations';


    public function storeCart(array $cart_info)
    {
        CartOfIllustration::insert($cart_info);
    }
}
