<?php

declare(strict_types=1);

namespace App\Domain\Partners\Actions;

use App\Models\PartnerLink;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GeneratePartnerAccessLinkAction
{
    /**
     * @return array{raw_token: string, link: PartnerLink}
     */
    public function __invoke(int $siteId, ?\DateTimeInterface $validFrom, ?\DateTimeInterface $validUntil, ?int $maxUses, ?int $creatorUserId = null): array
    {
        $rawToken = Str::random(40);
        $tokenHash = Hash::make($rawToken);

        $link = DB::transaction(function () use ($siteId, $validFrom, $validUntil, $maxUses, $creatorUserId, $tokenHash) {
            return PartnerLink::create([
                'site_id' => $siteId,
                'token_hash' => $tokenHash,
                'status' => 'active',
                'valid_from' => $validFrom,
                'valid_until' => $validUntil,
                'max_uses' => $maxUses,
                'created_by' => $creatorUserId,
            ]);
        });

        return [
            'raw_token' => $rawToken,
            'link' => $link,
        ];
    }
}
