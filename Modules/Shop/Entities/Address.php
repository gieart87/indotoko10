<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\UuidTrait;

class Address extends Model
{
    use HasFactory, UuidTrait;

    protected $table = 'shop_addresses';

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Shop\Database\factories\AddressFactory::new();
    }
}
