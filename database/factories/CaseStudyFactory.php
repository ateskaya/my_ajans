<?php

namespace Database\Factories;

use App\Models\CaseStudy;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CaseStudy>
 */
class CaseStudyFactory extends Factory
{
    protected $model = CaseStudy::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numerify('###'),
            'client_name' => fake()->company(),
            'problem' => fake()->paragraph(3),
            'solution' => fake()->paragraph(4),
            'impact_metrics' => [
                'speed_increase' => fake()->numberBetween(20, 60).'%',
                'cost_reduction' => fake()->numberBetween(10, 35).'%',
                'uptime' => fake()->randomFloat(1, 99.5, 99.99).'%',
            ],
            'cover_image' => null,
            'is_featured' => fake()->boolean(40),
        ];
    }
}
