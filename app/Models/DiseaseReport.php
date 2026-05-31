<?php

namespace App\Models;

use App\Traits\HasActivityFeed;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiseaseReport extends Model
{
    /** @use HasFactory<\Database\Factories\DiseaseReportFactory> */
    use HasActivityFeed;
    use HasFactory;

    protected $fillable = [
        'user_id',
        'crop_id',
        'image_path',
        'predicted_disease',
        'confidence',
        'symptoms',
        'cure',
        'fertilizer_recommendation',
        'notes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'confidence' => 'decimal:2',
        ];
    }

    public function farmer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function crop(): BelongsTo
    {
        return $this->belongsTo(Crop::class);
    }
}
