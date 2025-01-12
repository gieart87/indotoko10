<?php

namespace App\Livewire\Admin\Product;

use Illuminate\Validation\Rule;
use Livewire\Component;
use Modules\Shop\Entities\Product;
use Illuminate\Support\Str;

class ProductCreate extends Component
{
    public $sku, $name, $type;

    protected function rules()
    {
        return [
            'sku' => [
                'required',
                'string',
                Rule::unique('shop_products', 'sku'),
            ],
            'name' => [
                'required',
                'string',
            ],
            'type' => [
                'required',
                'string',
            ]
        ];
    }
    public function render()
    {
        return view('livewire.admin.product.product-create');
    }

    public function save()
    {
        $params = $this->validate();
        $params['user_id'] = auth()->user()->id;
        $params['slug'] = Str::slug($params['name']);
        $params['status'] = Product::INACTIVE;

        if ($product = Product::create($params)) {
            session()->flash('success', 'Product created!');

            $this->reset();

            $this->redirectRoute('admin.products.update', ['id' => $product->id]);
            return;
        }

        session()->flash('error', 'Failed!');
    }

    public function close()
    {
        $this->reset();
    }
}
