<?php

namespace Database\Factories;

use App\Models\Digital;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Digital>
 */
class DigitalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->streetName(),
            'slug' => $this->faker->unique()->slug(),
            'creation_date' => $this->faker->date()
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Digital $digital){
            
            $images = collect([]);

            for ($i = 0; $i < rand(1, 5); $i++){

                $id = Image::factory()->create()->id;

                $images->put($id, ['order' => $i]);
            }

            $digital->images()->sync($images);
        });
    }
}
