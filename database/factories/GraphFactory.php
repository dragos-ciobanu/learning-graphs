<?php

namespace Database\Factories;

use App\Models\GraphObject;
use Illuminate\Database\Eloquent\Factories\Factory;

class GraphFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GraphObject::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'vertices_count' => 0,
            'edges_count' => 0,
            'edges' => [[]],
            'matrix' => [[]],
        ];
    }
}
