<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\PartnerLink;
use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class EnsurePartnerLinkIsValid
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = (string) $request->route('token');

        // Guard: missing token
        if ($token === '') {
            abort(404);
        }

        // Find active links and match by hash
        $query = PartnerLink::query()
            ->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('valid_from')->orWhere('valid_from', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('valid_until')->orWhere('valid_until', '>=', now());
            });

        $match = null;
        foreach ($query->cursor() as $candidate) {
            if (Hash::check($token, (string) $candidate->token_hash)) {
                $match = $candidate;
                break;
            }
        }

        if ($match === null) {
            abort(403, 'Invalid or expired link.');
        }

        if ($match->max_uses !== null && $match->used_count >= $match->max_uses) {
            abort(429, 'Usage limit exceeded.');
        }

        // Attach site_id to request for downstream usage
        $request->attributes->set('partner_site_id', $match->site_id);
        $request->attributes->set('partner_link_id', $match->id);

        return $next($request);
    }
}
