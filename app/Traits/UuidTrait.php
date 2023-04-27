<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UuidTrait
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->incrementing = false;
            $model->keyType = 'string';
            $model->{$model->getKeyName()} = Str::orderedUuid()->toString();
        });
    }

    public function getIncrementing()
    {
        return false;
    }
    
    public function getKeyType()
    {
        return 'string';
    }
}