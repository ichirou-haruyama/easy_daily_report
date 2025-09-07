<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Site>
 */
class SiteFactory extends Factory
{
    protected $model = Site::class;

    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-2 months', '+1 month');
        $end = (clone $start)->modify('+' . random_int(7, 60) . ' days');

        return [
            'name' => $this->faker->company() . ' 工事',
            'code' => strtoupper($this->faker->bothify('S-####')),
            'starts_on' => $start->format('Y-m-d'),
            'ends_on' => $this->faker->boolean(70) ? $end->format('Y-m-d') : null,
            'settled_at' => null,
            'is_active' => true,
            'notes' => $this->faker->boolean(50) ? $this->faker->sentence() : null,
        ];
    }
}
