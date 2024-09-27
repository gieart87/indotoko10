<?php

namespace App\Livewire\Admin\Category;

use Illuminate\Validation\Rule;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Modules\Shop\Entities\Category;

class CreateUpdateCategory extends Component
{
    public $editMode = false;
    public $name;
    public $category;

    public function render()
    {
        return view('livewire.admin.category.create-update-category');
    }

    protected function rules()
    {
        if ($this->editMode == true) {
            return [
                'name' => [
                    'required',
                    'string',
                    Rule::unique('shop_categories', 'name')->ignore($this->category->id),
                ]
            ];
        }

        return [
            'name' => [
                'required',
                'string',
                Rule::unique('shop_categories', 'name'),
            ]
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        $params = [
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ];

        if (Category::create($params)) {
            session()->flash('success', 'Category created!');

            $this->dispatch('category-created');
            $this->reset();
            return;
        }

        session()->flash('error', 'Failed');
    }

    #[On('edit-category')]
    public function edit($id)
    {
        $this->editMode = true;

        $category = Category::findOrFail($id);

        $this->name = $category->name;
        $this->category = $category;
    }

    public function update()
    {
        $validated = $this->validate();
    
        $params = [
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ];

        if ($this->category->update($params)) {
            $this->dispatch('category-updated');

            session()->flash('success', 'Category updated!');
            $this->reset();
            return;
        }

        session()->flash('error', 'Failed');
    }


    public function close()
    {
        $this->reset();
    }
}
