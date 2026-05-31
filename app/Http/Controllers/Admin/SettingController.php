<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        return view('admin.settings.index', [
            'settings' => Setting::query()->orderBy('group')->orderBy('label')->paginate(15),
        ]);
    }

    public function store(SettingRequest $request): RedirectResponse
    {
        Setting::create($request->validated());

        return back()->with('success', 'Setting created successfully.');
    }

    public function update(SettingRequest $request, Setting $setting): RedirectResponse
    {
        $setting->update($request->validated());

        return back()->with('success', 'Setting updated successfully.');
    }
}
