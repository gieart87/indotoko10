<?php

namespace Modules\Shop\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Shop\Entities\Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = fake()->sentence(2);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}

