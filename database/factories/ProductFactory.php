<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Group;
use App\Models\Sticker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->word(),
            'description' => fake()->paragraph(1),
            'preview_image' => Storage::disk('public')->put('/images', new File(fake()->image(null, 360, 360))),
            'color' => fake()->safeHexColor(),
            'group_id' => Group::all()->random()->id,
            'category_id' => Category::all()->random()->id,
            'sticker_id' => Sticker::all()->random()->id,
            'price' => fake()->numberBetween(1, 1000),
            'is_published' => 1
        ];
    }
}
