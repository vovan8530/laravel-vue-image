<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ImagesFactory extends Factory
{
    protected $model = Image::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'path' => $this->faker->word(),
            'url' => $this->faker->url(),
        ];
    }
}
