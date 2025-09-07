<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Report;
use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        $user = User::inRandomOrder()->first() ?? User::factory()->create();
        $site = Site::inRandomOrder()->first() ?? Site::factory()->create();

        $workDate = $this->faker->dateTimeBetween('-30 days', 'now');
        $clockIn = Carbon::instance($workDate)->setTime(random_int(6, 10), [0, 15, 30, 45][random_int(0, 3)]);
        $clockOut = (clone $clockIn)->addHours(random_int(6, 12))->addMinutes([0, 15, 30, 45][random_int(0, 3)]);
        $break = [0, 30, 45, 60][random_int(0, 3)];

        $worked = max(0, $clockIn->diffInMinutes($clockOut) - $break);

        return [
            'user_id' => $user->id,
            'site_id' => $site->id,
            'work_date' => $clockIn->toDateString(),
            'clock_in_at' => $clockIn,
            'clock_out_at' => $clockOut,
            'break_minutes' => $break,
            'work_minutes' => $worked,
            'status' => $this->faker->randomElement(['draft', 'submitted', 'approved', 'rejected']),
            'title' => $this->faker->boolean(70) ? $this->faker->sentence(3) : null,
            'content' => $this->faker->boolean(80) ? $this->faker->paragraph() : null,
            'meta' => null,
        ];
    }
}
