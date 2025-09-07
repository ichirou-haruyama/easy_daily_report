<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Report;
use App\Models\ReportPhoto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\ReportPhoto>
 */
class ReportPhotoFactory extends Factory
{
    protected $model = ReportPhoto::class;

    public function definition(): array
    {
        $report = Report::inRandomOrder()->first() ?? Report::factory()->create();
        $filename = $this->faker->uuid . '.jpg';

        return [
            'report_id' => $report->id,
            'path' => 'reports/' . $report->id . '/' . $filename,
            'thumbnail_path' => 'reports/' . $report->id . '/thumb_' . $filename,
            'mime_type' => 'image/jpeg',
            'size_bytes' => $this->faker->numberBetween(80_000, 3_000_000),
            'caption' => $this->faker->boolean(50) ? $this->faker->sentence(4) : null,
        ];
    }
}
