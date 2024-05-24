<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [];

    public const EXPIRY_DURATION = 1;
    public const EXPIRY_UNIT = 'days';
    public const PAYMENT_CHANNELS = [
        'mandiri_clickpay',
        'cimb_clicks',
        'bca_klikbca',
        'bca_klikpay',
        'bri_epay',
        'echannel',
        'permata_va',
        'bca_va',
        'bni_va',
        'other_va',
        'gopay',
        'indomaret',
        'danamon_online',
    ];
    
    protected static function newFactory()
    {
        return \Modules\Shop\Database\factories\PaymentFactory::new();
    }
}
