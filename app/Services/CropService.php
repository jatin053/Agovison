<?php

namespace App\Services;

use App\Events\CropApproved;
use App\Models\Crop;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CropService
{
    public function __construct(
        private readonly ActivityLogService $activityLogService,
        private readonly ImageUploadService $imageUploadService,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(User $farmer, array $data): Crop
    {
        return DB::transaction(function () use ($farmer, $data) {
            $payload = Arr::except($data, ['images', 'remove_images']);

            $crop = Crop::create([
                ...$payload,
                'user_id' => $farmer->id,
                'slug' => $this->generateUniqueSlug($data['title']),
                'status' => 'pending',
            ]);

            $this->syncImages($crop, $data['images'] ?? []);
            $this->activityLogService->log('crop.created', 'Crop created by farmer.', $crop, $farmer);

            return $crop->load(['category', 'images']);
        });
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(Crop $crop, array $data, ?User $actor = null): Crop
    {
        return DB::transaction(function () use ($crop, $data, $actor) {
            $payload = Arr::except($data, ['images', 'remove_images']);

            $crop->update([
                ...$payload,
                'slug' => $this->generateUniqueSlug($data['title'], $crop->id),
                'status' => $actor?->hasRole('Admin') ? ($data['status'] ?? $crop->status) : 'pending',
            ]);

            if (! empty($data['remove_images'])) {
                $crop->images()
                    ->whereIn('id', $data['remove_images'])
                    ->get()
                    ->each(function ($image) {
                        Storage::disk('public')->delete($image->image_path);
                        $image->delete();
                    });
            }

            $this->syncImages($crop, $data['images'] ?? []);
            $this->activityLogService->log('crop.updated', 'Crop updated.', $crop, $actor);

            return $crop->load(['category', 'images']);
        });
    }

    public function approve(Crop $crop, User $admin): Crop
    {
        $crop->update([
            'approved_at' => now(),
            'approved_by' => $admin->id,
            'status' => 'approved',
        ]);

        event(new CropApproved($crop, $admin));
        $this->activityLogService->log('crop.approved', 'Crop approved by admin.', $crop, $admin);

        return $crop;
    }

    public function reject(Crop $crop, User $admin): Crop
    {
        $crop->update([
            'approved_at' => null,
            'approved_by' => $admin->id,
            'status' => 'rejected',
        ]);

        $this->activityLogService->log('crop.rejected', 'Crop rejected by admin.', $crop, $admin);

        return $crop;
    }

    /**
     * @param  array<int, mixed>  $files
     */
    private function syncImages(Crop $crop, array $files): void
    {
        if ($files === []) {
            return;
        }

        $startingCount = $crop->images()->count();
        $paths = $this->imageUploadService->storeMultiple($files, 'crops');

        foreach ($paths as $index => $path) {
            $crop->images()->create([
                'image_path' => $path,
                'is_primary' => $startingCount === 0 && $index === 0,
                'sort_order' => $startingCount + $index,
            ]);
        }
    }

    private function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $baseSlug = $slug;
        $counter = 1;

        while (
            Crop::query()
                ->when($ignoreId, static fn ($query) => $query->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$counter++;
        }

        return $slug;
    }
}
