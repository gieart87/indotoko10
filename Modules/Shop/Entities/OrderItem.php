<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'shop_order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'base_price',
        'base_total',
        'tax_amount',
        'tax_percent',
        'discount_amount',
        'discount_percent',
        'sub_total',
        'sku',
        'type',
        'name',
        'attributes',
    ];
    
    protected static function newFactory()
    {
        return \Modules\Shop\Database\factories\OrderItemFactory::new();
    }

    public function order() :BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
