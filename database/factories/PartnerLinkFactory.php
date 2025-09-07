<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\PartnerLink;
use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<\App\Models\PartnerLink>
 */
class PartnerLinkFactory extends Factory
{
    protected $model = PartnerLink::class;

    public function definition(): array
    {
        $site = Site::inRandomOrder()->first() ?? Site::factory()->create();
        $creator = User::inRandomOrder()->first() ?? User::factory()->create();

        $rawToken = bin2hex(random_bytes(16));

        return [
            'site_id' => $site->id,
            'token_hash' => Hash::make($rawToken),
            'status' => 'active',
            'valid_from' => now()->subDay(),
            'valid_until' => now()->addDays(14),
            'max_uses' => random_int(1, 50),
            'used_count' => 0,
            'created_by' => $creator->id,
            'notes' => 'サンプルQR招待リンク',
        ];
    }
}
