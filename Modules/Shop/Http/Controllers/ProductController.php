<?php

namespace Modules\Shop\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Modules\Shop\Repositories\Front\Interfaces\ProductRepositoryInterface;
use Modules\Shop\Repositories\Front\Interfaces\CategoryRepositoryInterface;
use Modules\Shop\Repositories\Front\Interfaces\TagRepositoryInterface;

class ProductController extends Controller
{
    protected $productRepository;
    protected $categoryRepository;
    protected $tagRepository;

    public function __construct(ProductRepositoryInterface $productRepository, CategoryRepositoryInterface $categoryRepository, TagRepositoryInterface $tagRepository)
    {
        parent::__construct();

        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;

        $this->data['categories'] = $this->categoryRepository->findAll();
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $options = [
            'per_page' => $this->perPage,
        ];
        
        $this->data['products'] = $this->productRepository->findAll($options);
        
        return $this->loadTheme('products.index', $this->data);
    }

    public function category($categorySlug)
    {
        $category = $this->categoryRepository->findBySlug($categorySlug);

        $options = [
            'per_page' => $this->perPage,
            'filter' => [
                'category' => $categorySlug,
            ]
        ];

        $this->data['products'] = $this->productRepository->findAll($options);
        $this->data['category'] = $category;

        return $this->loadTheme('products.category', $this->data);
    }

    public function tag($tagSlug)
    {
        $tag = $this->tagRepository->findBySlug($tagSlug);
        
        $options = [
            'per_page' => $this->perPage,
            'filter' => [
                'tag' => $tagSlug,
            ]
        ];

        $this->data['products'] = $this->productRepository->findAll($options);
        $this->data['tag'] = $tag;

        return $this->loadTheme('products.tag', $this->data);
    }
}
