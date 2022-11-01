<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $ratio = rand(1000, 2000)/rand(1000, 2000);

        return [
            'url' => $this->faker->unique()->imageUrl(2000*$ratio, 2000/$ratio),
            'thumb' => $this->faker->unique()->imageUrl(150*$ratio, 150/$ratio),
            'name' => $this->faker->streetName()
        ];
    }
}
