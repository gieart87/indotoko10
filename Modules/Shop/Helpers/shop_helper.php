<?php

if (!function_exists('shop_product_link')) {
    function shop_product_link($product) {
        $categorySlug = 'produk';

        if ($product->categories->count() > 0) {
            $categorySlug = $product->categories->first()->slug;
        }

        return url($categorySlug . '/' . $product->slug . '-' . $product->sku);
    }
}