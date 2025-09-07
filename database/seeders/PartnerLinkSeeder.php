<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\PartnerLink;
use App\Models\Site;
use Illuminate\Database\Seeder;

class PartnerLinkSeeder extends Seeder
{
    public function run(): void
    {
        if (Site::count() === 0) {
            Site::factory()->count(3)->create();
        }

        PartnerLink::factory()->count(8)->create();
    }
}
