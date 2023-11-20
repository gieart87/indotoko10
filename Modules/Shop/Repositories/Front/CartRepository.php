<?php

namespace Modules\Shop\Repositories\Front;

use App\Models\User;
use Modules\Shop\Entities\Cart;
use Modules\Shop\Repositories\Front\Interfaces\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface {
    
    public function findByUser(User $user)
    {
        $cart = Cart::with([
                'items',
                'items.product',
            ])->forUser($user)->first();

        return $cart;
    }
}