<?php

namespace Modules\Shop\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
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

    public function shippingFee(Request $request)
    {
        $address = $this->addressRepository->findByID($request->get('address_id'));
        $cart = $this->cartRepository->findByUser(auth()->user());
        
        $availableServices = $this->calculateShippingFee($cart, $address, $request->get('courier'));
        return $this->loadTheme('orders.available_services', ['services' => $availableServices]);
    }

    public function choosePackage(Request $request)
    {
        $address = $this->addressRepository->findByID($request->get('address_id'));
        $cart = $this->cartRepository->findByUser(auth()->user());
        
        $availableServices = $this->calculateShippingFee($cart, $address, $request->get('courier'));

        $selectedPackage = null;
        if (!empty($availableServices)) {
            foreach ($availableServices as $service) {
                if ($service['service'] === $request->get('delivery_package')) {
                    $selectedPackage = $service;
                    continue;
                }
            }
        }

        if ($selectedPackage == null) {
            return [];
        }

        return [
            'shipping_fee' => number_format($selectedPackage['cost']),
            'grand_total' => number_format($cart->grand_total + $selectedPackage['cost']),
        ];
    }

    private function calculateShippingFee($cart, $address, $courier) {
        $shippingFees = [];

        try {
            $response = Http::withHeaders([
                'key' => env('API_ONGKIR_KEY'),
            ])->post(env('API_ONGKIR_BASE_URL'). 'cost', [
                'origin' => env('API_ONGKIR_ORIGIN'),
                'destination' => $address->city,
                'weight' => $cart->total_weight,
                'courier' => $courier,
            ]);

            $shippingFees = json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return [];
        }

        $availableServices = [];
        if (!empty($shippingFees['rajaongkir']['results'])) {
            foreach ($shippingFees['rajaongkir']['results'] as $cost) {
                if (!empty($cost['costs'])) {
                    foreach ($cost['costs'] as $costDetail) {
                        $availableServices[] = [
                            'service' => $costDetail['service'],
                            'description' => $costDetail['description'],
                            'etd' => $costDetail['cost'][0]['etd'],
                            'cost' => $costDetail['cost'][0]['value'],
                            'courier' => $courier,
                            'address_id' => $address->id,
                        ];
                    }
                }
            }
        }

        return $availableServices;
    }
}
