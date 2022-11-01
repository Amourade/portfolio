<?php

namespace Database\Factories;

use App\Models\Drawing;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Drawing>
 */
class DrawingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $video = (rand(0, 10) > 5) ? 'u5bYRqYyLfM' : null;
        return [
            'title' => $this->faker->streetName(),
            'slug' => $this->faker->unique()->slug(),
            'description' => $this->faker->text(),
            'creation_date' => $this->faker->date(),
            'height' => $this->faker->randomFloat(2, 10, 70),
            'width' => $this->faker->randomFloat(2, 10, 70),
            'video' => $video
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Drawing $drawing){
            
            $images = collect([]);

            for ($i = 0; $i < rand(1, 8); $i++){

                $id = Image::factory()->create()->id;

                $images->put($id, ['order' => $i]);
            }

            $drawing->images()->sync($images);
        });
    }
}