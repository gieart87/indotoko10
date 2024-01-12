<?php

namespace Modules\Shop\Repositories\Front;

use App\Models\User;
use Carbon\Carbon;
use Modules\Shop\Entities\Cart;
use Modules\Shop\Entities\CartItem;
use Modules\Shop\Repositories\Front\Interfaces\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface {
    
    public function findByUser(User $user): Cart
    {
        $cart = Cart::with([
                'items',
                'items.product',
        ])->forUser($user)->first();

        if (!$cart) {
            return Cart::create([
                'user_id' => $user->id,
                'expired_at' => (new Carbon())->addDay(7),
            ]);
        }

        $this->calculateCart($cart);

        return $cart;
    }

    public function addItem($product, $qty): CartItem
    {
        $cart = $this->findByUser(auth()->user());
        
        $existItem = CartItem::where([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ])->first();
        
        if (!$existItem) {
            return CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'qty' => $qty,
            ]);
        }

        if (($existItem->qty + $qty) > $product->stock) {
            return new CartItem();
        }

        $existItem->qty = $existItem->qty + $qty;
        $existItem->save();

        return $existItem;
    }

    public function removeItem($id) : bool
    {
        return CartItem::where('id', $id)->delete();
    }

    public function updateQty($items = []): void
    {
        if (!empty($items)) {
            foreach ($items as $itemID => $qty) {
                $item = CartItem::where('id', $itemID)->first();
                if ($item) {
                    $item->qty = $qty;
                    $item->save();
                }
            }
        }
    }

    private function calculateCart(Cart $cart): void
    {
        $baseTotalPrice = 0;
        $taxAmount = 0;
        $discountAmount = 0;
        $grandTotal = 0;

        if (count($cart->items) > 0) {
            foreach ($cart->items as $item) {
                $baseTotalPrice += $item->qty * $item->product->price;

                if ($item->product->has_sale_price) {
                    $discountAmountItem = $item->product->price - $item->product->sale_price;
                    $discountAmount += $item->qty * $discountAmountItem;
                }
            }
        }

        $nettTotal = $baseTotalPrice - $discountAmount;
        $taxAmount = 0.11 * $nettTotal;
        $grandTotal = $nettTotal + $taxAmount;

        $cart->update([
            'base_total_price' => $baseTotalPrice,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'grand_total' => $grandTotal,
        ]);
    }
}