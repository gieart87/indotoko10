<?php

namespace App\Livewire\Admin\Product;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Modules\Shop\Entities\Product;
use Modules\Shop\Repositories\Front\Interfaces\ProductRepositoryInterface;

class ProductUpdate extends Component
{
    public $id;
    public Product $product;

    public string $sku, $name, $excerpt, $body, $status;
    public float $price, $sale_price;

    private $productRepository;

    public function boot(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function mount()
    {
        $this->product = $this->productRepository->findByID($this->id);

        $this->sku = $this->product->sku;
        $this->name = $this->product->name;
        $this->excerpt = (string) $this->product->excerpt;
        $this->body = (string) $this->product->body;
        $this->price = (float) $this->product->price;
        $this->sale_price = (float) $this->product->sale_price;
        $this->status = $this->product->status;
    }

    protected function rules()
    {
        return [
            'sku' => [
                'required',
                'string',
                Rule::unique('shop_products', 'sku')->ignore($this->product->id),
            ],
            'name' => [
                'required',
                'string',
            ],
            'price' => [
                'required',
                'numeric',
            ],
            'sale_price' => [
                'numeric',
            ],
            'excerpt' => [
                'string',
            ],
            'body' => [
                'string',
            ],
            'status' => [
                'required',
                'string',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.admin.product.product-update', [
            'product' => $this->product,
        ]);
    }

    public function update()
    {
        $params = $this->validate();

        $updated = DB::transaction(function () use ($params) {
            return $this->product->update($params);
        });

        if ($updated) {
            session()->flash('success', 'Product updated!');
            return;
        }

        session()->flash('error', 'Failed');
    }
}
