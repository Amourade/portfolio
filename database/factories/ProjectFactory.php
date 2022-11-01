<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
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
            'slug' => $this->faker->unique->slug(),
            'description' => $this->faker->text(),
            'creation_date' => $this->faker->date(),
            'url' => $this->faker->url()
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Project $project){
            
            $images = collect([]);

            for ($i = 0; $i < rand(1, 8); $i++){

                $id = Image::factory()->create()->id;

                $images->put($id, ['order' => $i]);
            }

            $project->images()->sync($images);
        });
    }
}
