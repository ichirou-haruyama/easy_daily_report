<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Report;
use App\Models\ReportComment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\ReportComment>
 */
class ReportCommentFactory extends Factory
{
    protected $model = ReportComment::class;

    public function definition(): array
    {
        $report = Report::inRandomOrder()->first() ?? Report::factory()->create();
        $user = User::inRandomOrder()->first() ?? User::factory()->create();

        return [
            'report_id' => $report->id,
            'user_id' => $user->id,
            'body' => $this->faker->sentences(random_int(1, 3), true),
            'is_internal' => $this->faker->boolean(30),
        ];
    }
}
