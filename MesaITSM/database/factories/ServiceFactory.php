<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Service;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition()
    {
        $name = fake()->words(2, true);
        return [
            'name' => ucfirst($name),
            'slug' => str()->slug($name) . '-' . fake()->unique()->numberBetween(1,999),
            'description' => fake()->sentence(),
            'active' => true,
        ];
    }
}
