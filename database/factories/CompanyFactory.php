<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $companyName = fake()->company();
        $filename = Str::snake($companyName);

        // We need to make up the image url ourselves as the Faker library cannot generate a valid URL
        // E.g. https://picsum.photos/100x100.jpg
        // which is no longer used by picsum.photos
        Storage::put("public/{$filename}.jpg", file_get_contents('https://picsum.photos/100/100'));

        return [
            'name' => $companyName,
            'logo' => "/storage/{$filename}.jpg",
        ];
    }
}
