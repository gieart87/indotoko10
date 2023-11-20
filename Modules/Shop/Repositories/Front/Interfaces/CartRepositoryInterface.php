<?php

namespace Modules\Shop\Repositories\Front\Interfaces;

use App\Models\User;

interface CartRepositoryInterface
{
    public function findByUser(User $user);
}