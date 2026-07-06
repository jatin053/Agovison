<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class DiseaseDetection extends Model
{
    protected $fillable = [
        'user_id',
        'crop_name',
        'image_path',
        'affected_part',
        'symptoms',
        'location',
        'crop_age',
        'symptom_started',
        'field_affected',
        'fertilizer_used',
        'pesticide_used',
        'disease_name',
        'confidence',
        'possible_cause',
        'treatment',
        'prevention',
        'alternatives',
        'status',
        'plant_part',
        'visible_symptom',
        'symptom_notes',
        'leaf_image_path',
        'detected_disease',
        'severity',
        'confidence_score',
        'analysis_source',
        'treatment_suggestion',
        'raw_response',
    ];

    protected $casts = [
        'alternatives' => 'array',
        'confidence' => 'decimal:2',
        'created_at' => 'datetime',
        'raw_response' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function productRecommendations(): array
    {
        $context = strtolower(implode(' ', array_filter([
            $this->disease_name,
            $this->possible_cause,
            $this->symptoms,
            $this->severity,
        ])));

        if (str_contains($context, 'powder') || str_contains($context, 'mildew')) {
            return [
                [
                    'name' => 'Wettable sulphur or potassium bicarbonate fungicide',
                    'type' => 'Fungicide',
                    'reason' => 'Useful for many powdery mildew style fungal infections when applied early.',
                ],
                [
                    'name' => 'Neem oil spray',
                    'type' => 'Organic support',
                    'reason' => 'Helps reduce surface fungal pressure and some soft-bodied insects.',
                ],
            ];
        }

        if (str_contains($context, 'blight') || str_contains($context, 'fungal') || str_contains($context, 'spot') || str_contains($context, 'rot')) {
            return [
                [
                    'name' => 'Mancozeb or copper oxychloride based fungicide',
                    'type' => 'Fungicide',
                    'reason' => 'Commonly used for fungal leaf spots, blight, and many early-stage fungal infections.',
                ],
                [
                    'name' => 'Trichoderma based bio-fungicide',
                    'type' => 'Bio-control',
                    'reason' => 'Can support soil and root health, especially where fungal pressure is recurring.',
                ],
            ];
        }

        if (str_contains($context, 'curl') || str_contains($context, 'hole') || str_contains($context, 'insect') || str_contains($context, 'pest') || str_contains($context, 'virus')) {
            return [
                [
                    'name' => 'Neem oil or insecticidal soap',
                    'type' => 'Pest control',
                    'reason' => 'Can help manage sucking pests that spread curling, yellowing, and viral symptoms.',
                ],
                [
                    'name' => 'Yellow sticky traps',
                    'type' => 'Monitoring product',
                    'reason' => 'Helps monitor and reduce whiteflies, aphids, and other flying pest pressure.',
                ],
            ];
        }

        if (str_contains($context, 'yellow') || str_contains($context, 'weak') || str_contains($context, 'deficiency') || str_contains($context, 'nutrient')) {
            return [
                [
                    'name' => 'Balanced NPK fertilizer with micronutrients',
                    'type' => 'Nutrition',
                    'reason' => 'Supports weak growth, yellowing, and nutrient deficiency style symptoms after soil testing.',
                ],
                [
                    'name' => 'Seaweed or humic acid plant tonic',
                    'type' => 'Plant support',
                    'reason' => 'Can help stressed plants recover when combined with proper nutrition and irrigation.',
                ],
            ];
        }

        return [
            [
                'name' => 'Broad-spectrum bio-fungicide',
                'type' => 'General crop care',
                'reason' => 'A safer first option while the disease is being confirmed by an expert.',
            ],
            [
                'name' => 'Neem oil spray',
                'type' => 'General crop care',
                'reason' => 'Useful for light pest pressure and early surface disease management.',
            ],
        ];
    }
}
