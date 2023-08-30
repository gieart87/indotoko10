<?php

namespace Modules\Shop\Repositories\Front\Interfaces;

interface TagRepositoryInterface
{
    public function findAll($options = []);
    public function findBySlug($slug);
}