<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\UuidTrait;

class ProductInventory extends Model
{
    use HasFactory, UuidTrait;

    protected $table = 'shop_product_inventories';
    
    protected $fillable = [
        'product_id',
        'qty',
        'low_stock_threshold',
    ];

    protected static function newFactory()
    {
        return \Modules\Shop\Database\factories\ProductInventoryFactory::new();
    }
}
