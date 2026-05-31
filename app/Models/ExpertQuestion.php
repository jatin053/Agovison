<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpertQuestion extends Model
{
    /** @use HasFactory<\Database\Factories\ExpertQuestionFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'crop_id',
        'expert_id',
        'title',
        'question',
        'priority',
        'status',
        'answered_at',
    ];

    protected function casts(): array
    {
        return [
            'answered_at' => 'datetime',
        ];
    }

    public function farmer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function expert(): BelongsTo
    {
        return $this->belongsTo(User::class, 'expert_id');
    }

    public function crop(): BelongsTo
    {
        return $this->belongsTo(Crop::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(ExpertAnswer::class)->latest();
    }
}
