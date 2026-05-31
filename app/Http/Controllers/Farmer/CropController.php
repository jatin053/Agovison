<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CropRequest;
use App\Models\Category;
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
        return view('farmer.crops.index', [
            'categories' => Category::active()->get(),
            'crops' => $cropRepository->farmerInventory(auth()->user(), $request->all()),
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    public function create(): View
    {
        return view('farmer.crops.form', [
            'categories' => Category::active()->get(),
            'crop' => new Crop(),
            'formAction' => route('farmer.crops.store'),
            'method' => 'POST',
        ]);
    }

    public function store(CropRequest $request, CropService $cropService): RedirectResponse
    {
        $cropService->create(auth()->user(), $request->validated() + [
            'images' => $request->file('images', []),
        ]);

        return redirect()->route('farmer.crops.index')->with('success', 'Crop listing created successfully.');
    }

    public function edit(Crop $crop): View
    {
        $this->authorize('update', $crop);

        return view('farmer.crops.form', [
            'categories' => Category::active()->get(),
            'crop' => $crop->load('images'),
            'formAction' => route('farmer.crops.update', $crop),
            'method' => 'PUT',
        ]);
    }

    public function update(CropRequest $request, Crop $crop, CropService $cropService): RedirectResponse
    {
        $this->authorize('update', $crop);

        $cropService->update($crop, $request->validated() + [
            'images' => $request->file('images', []),
            'remove_images' => $request->input('remove_images', []),
        ], auth()->user());

        return redirect()->route('farmer.crops.index')->with('success', 'Crop listing updated successfully.');
    }

    public function destroy(Crop $crop): RedirectResponse
    {
        $this->authorize('delete', $crop);
        $crop->delete();

        return back()->with('success', 'Crop listing deleted successfully.');
    }
}
