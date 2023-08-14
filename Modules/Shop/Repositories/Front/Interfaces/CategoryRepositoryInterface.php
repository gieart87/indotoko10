<?php

namespace Modules\Shop\Repositories\Front\Interfaces;

interface CategoryRepositoryInterface
{
    public function findAll($options = []);
    public function findBySlug($slug);
}