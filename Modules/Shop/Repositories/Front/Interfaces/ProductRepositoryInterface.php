<?php

namespace Modules\Shop\Repositories\Front\Interfaces;

interface ProductRepositoryInterface
{
    public function findAll($options = []);
    public function findBySKU($sku);
    public function findByID($id);
}