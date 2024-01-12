<?php

namespace Modules\Shop\Repositories\Front;

use App\Models\User;
use Modules\Shop\Entities\Address;
use Modules\Shop\Repositories\Front\Interfaces\AddressRepositoryInterface;

class AddressRepository implements AddressRepositoryInterface {
    
    public function findByUser(User $user)
    {
        return Address::where('user_id', $user->id)->get();
    }
}