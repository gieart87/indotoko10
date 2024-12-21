<?php

namespace App\Livewire\Admin\Product;

use Livewire\Attributes\Url;
use Livewire\Component;
use Modules\Shop\Entities\Product;

class ProductIndex extends Component
{
    public $perPage = 10;

    #[Url(as: 'q')]
    public ?string $search;

    public function render()
    {
        $products = Product::orderBy('created_at', 'desc');

        if (!empty($this->search)) {
            $products = $products->where('name', 'LIKE', '%'. $this->search . '%');
        }

        return view('livewire.admin.product.product-index', [
            'products' => $products->paginate($this->perPage),
        ]);
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        session()->flash('success', 'Product deleted!');
    }

    public function changePerPage($perPage)
    {
        if (($perPage < 5) || ($perPage > 25)) {
            $this->perPage = 5;
            return;
        }

        $this->perPage = $perPage;
    }
}
