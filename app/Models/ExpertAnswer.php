<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpertAnswer extends Model
{
    /** @use HasFactory<\Database\Factories\ExpertAnswerFactory> */
    use HasFactory;

    protected $fillable = [
        'expert_question_id',
        'expert_id',
        'answer',
        'is_solution',
    ];

    protected function casts(): array
    {
        return [
            'is_solution' => 'boolean',
        ];
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(ExpertQuestion::class, 'expert_question_id');
    }

    public function expert(): BelongsTo
    {
        return $this->belongsTo(User::class, 'expert_id');
    }
}
