<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Painting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Painting>
 */
class PaintingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $video = (rand(0, 1) === 0) ? 'n3kN4hrvEKg' : null;
        return [
            'title' => $this->faker->streetName(),
            'slug' => $this->faker->unique()->slug(),
            'description' => $this->faker->text(40),
            'creation_date' => $this->faker->date(),
            'video' => $video,
            'height' => $this->faker->randomFloat(2, 10, 70),
            'width' => $this->faker->randomFloat(2, 10, 70),
            'depth' => $this->faker->randomFloat(2, .5, 5)
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Painting $painting){
            
            $images = collect([]);

            for ($i = 0; $i < rand(1, 8); $i++){

                $id = Image::factory()->create()->id;

                $images->put($id, ['order' => $i]);
            }

            $painting->images()->sync($images);
        });
    }
}
