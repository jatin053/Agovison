<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Crop;
use App\Repositories\CropRepository;
use App\Services\CropService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CropController extends Controller
{
    public function index(Request $request, CropRepository $cropRepository): View
    {
        return view('admin.crops.index', [
            'filters' => $request->only(['search', 'category', 'status']),
            'crops' => $cropRepository->adminListing($request->all()),
        ]);
    }

    public function approve(Crop $crop, CropService $cropService): RedirectResponse
    {
        $cropService->approve($crop, auth()->user());

        return back()->with('success', 'Crop approved successfully.');
    }

    public function reject(Crop $crop, CropService $cropService): RedirectResponse
    {
        $cropService->reject($crop, auth()->user());

        return back()->with('success', 'Crop rejected successfully.');
    }

    public function destroy(Crop $crop): RedirectResponse
    {
        $crop->delete();

        return back()->with('success', 'Crop removed successfully.');
    }
}
