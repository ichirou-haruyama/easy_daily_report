<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Report;
use App\Models\ReportComment;
use App\Models\ReportPhoto;
use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReportDemoSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure some users exist
        if (User::count() === 0) {
            User::factory()->count(5)->create();
        }

        // Create sites
        $sites = Site::factory()->count(5)->create();

        // Create reports per site and user
        $users = User::all();
        foreach ($sites as $site) {
            foreach ($users as $user) {
                Report::factory()
                    ->count(random_int(2, 5))
                    ->state(fn() => [
                        'site_id' => $site->id,
                        'user_id' => $user->id,
                    ])
                    ->create()
                    ->each(function (Report $report): void {
                        // Photos
                        ReportPhoto::factory()->count(random_int(0, 3))->state([
                            'report_id' => $report->id,
                        ])->create();

                        // Comments
                        ReportComment::factory()->count(random_int(0, 2))->state([
                            'report_id' => $report->id,
                        ])->create();
                    });
            }
        }
    }
}
