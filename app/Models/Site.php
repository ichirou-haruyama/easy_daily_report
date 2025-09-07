<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Site extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'starts_on',
        'ends_on',
        'settled_at',
        'is_active',
        'notes',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'starts_on' => 'date',
        'ends_on' => 'date',
        'settled_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}
