<?php

namespace Modules\Shop\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Shop\Repositories\Front\Interfaces\AddressRepositoryInterface;
use Modules\Shop\Repositories\Front\Interfaces\CartRepositoryInterface;

class OrderController extends Controller
{

    protected $addressRepository;
    protected $cartRepository;

    public function __construct(AddressRepositoryInterface $addressRepository, CartRepositoryInterface $cartRepository)
    {
        $this->addressRepository = $addressRepository;
        $this->cartRepository = $cartRepository;
    }
   
    public function checkout()
    {
        $this->data['cart'] = $this->cartRepository->findByUser(auth()->user());
        $this->data['addresses'] = $this->addressRepository->findByUser(auth()->user());
    
        return $this->loadTheme('orders.checkout', $this->data);
    }

    public function shippingFee()
    {
        return $this->loadTheme('orders.shipping_fee');
    }
}
