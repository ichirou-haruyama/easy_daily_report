<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'site_id',
        'work_date',
        'clock_in_at',
        'clock_out_at',
        'break_minutes',
        'work_minutes',
        'status',
        'title',
        'content',
        'meta',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'work_date' => 'date',
        'clock_in_at' => 'datetime',
        'clock_out_at' => 'datetime',
        'break_minutes' => 'integer',
        'work_minutes' => 'integer',
        'meta' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ReportPhoto::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ReportComment::class);
    }
}
