<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CropRequest;
use App\Models\Crop;
use App\Repositories\CropRepository;
use App\Services\CropService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CropController extends Controller
{
    public function index(Request $request, CropRepository $cropRepository): JsonResponse
    {
        return response()->json([
            'data' => $cropRepository->approved($request->all())->items(),
        ]);
    }

    public function store(CropRequest $request, CropService $cropService): JsonResponse
    {
        $crop = $cropService->create($request->user(), $request->validated() + [
            'images' => $request->file('images', []),
        ]);

        return response()->json([
            'message' => 'Crop created successfully.',
            'data' => $crop,
        ], 201);
    }

    public function show(Crop $crop): JsonResponse
    {
        return response()->json([
            'data' => $crop->load(['category', 'farmer', 'images', 'reviews']),
        ]);
    }

    public function update(CropRequest $request, Crop $crop, CropService $cropService): JsonResponse
    {
        $this->authorize('update', $crop);

        $crop = $cropService->update($crop, $request->validated() + [
            'images' => $request->file('images', []),
            'remove_images' => $request->input('remove_images', []),
        ], $request->user());

        return response()->json([
            'message' => 'Crop updated successfully.',
            'data' => $crop,
        ]);
    }

    public function destroy(Crop $crop): JsonResponse
    {
        $this->authorize('delete', $crop);
        $crop->delete();

        return response()->json(['message' => 'Crop deleted successfully.']);
    }
}
