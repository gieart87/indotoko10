<?php

namespace Modules\Shop\Repositories\Front\Interfaces;

use App\Models\User;

interface AddressRepositoryInterface
{
    public function findByUser(User $user);
}