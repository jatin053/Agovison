<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SoilProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SoilReportController extends Controller
{
    public function index(Request $request): View
    {
        $query = $this->filteredQuery($request);

        return view('admin.soil.index', [
            'profiles' => $query->paginate(15)->withQueryString(),
            'summary' => [
                'total' => SoilProfile::count(),
                'manual' => SoilProfile::where('data_source', 'Manual Entry')->count(),
                'estimated' => SoilProfile::where('data_source', 'Estimated From Location')->count(),
                'verified' => SoilProfile::where('is_verified', true)->count(),
                'recent' => SoilProfile::latest()->take(5)->get(),
            ],
            'filters' => $request->query(),
        ]);
    }

    public function show(SoilProfile $soilProfile): View
    {
        return view('admin.soil.show', [
            'profile' => $soilProfile->load('user'),
        ]);
    }

    public function update(Request $request, SoilProfile $soilProfile): RedirectResponse
    {
        $data = $request->validate([
            'admin_note' => ['nullable', 'string', 'max:3000'],
            'is_verified' => ['nullable', 'boolean'],
        ]);

        $soilProfile->update([
            'admin_note' => $data['admin_note'] ?? null,
            'is_verified' => (bool) ($data['is_verified'] ?? false),
            'data_source' => (bool) ($data['is_verified'] ?? false) ? 'Admin Reviewed' : $soilProfile->data_source,
        ]);

        return back()->with('status', 'Soil report reviewed.');
    }

    public function destroy(SoilProfile $soilProfile): RedirectResponse
    {
        $soilProfile->delete();

        return redirect()->route('admin.soil.index')->with('status', 'Soil report deleted.');
    }

    public function csv(Request $request): Response
    {
        $rows = $this->filteredQuery($request)->get();
        $handle = fopen('php://temp', 'w+');
        fputcsv($handle, ['ID', 'User Name', 'Email', 'Location', 'Soil Type', 'pH', 'Nitrogen', 'Phosphorus', 'Potassium', 'Data Source', 'Verified', 'Date']);

        foreach ($rows as $profile) {
            fputcsv($handle, [
                $profile->id,
                $profile->user?->name,
                $profile->user?->email,
                $profile->location,
                $profile->soil_type,
                $profile->ph_value,
                $profile->nitrogen_level,
                $profile->phosphorus_level,
                $profile->potassium_level,
                $profile->data_source,
                $profile->is_verified ? 'Yes' : 'No',
                optional($profile->created_at)->format('Y-m-d H:i:s'),
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="soil-reports.csv"',
        ]);
    }

    private function filteredQuery(Request $request)
    {
        $query = SoilProfile::query()->with('user')->latest();

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($builder) use ($search) {
                $builder->where('location', 'like', '%'.$search.'%')
                    ->orWhere('soil_type', 'like', '%'.$search.'%')
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%'.$search.'%')
                            ->orWhere('email', 'like', '%'.$search.'%');
                    });
            });
        }

        foreach (['soil_type', 'nitrogen_level', 'phosphorus_level', 'potassium_level', 'data_source'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->string($field)->toString());
            }
        }

        if ($request->filled('verified')) {
            $query->where('is_verified', $request->boolean('verified'));
        }

        if ($request->filled('ph_min')) {
            $query->where('ph_value', '>=', (float) $request->input('ph_min'));
        }

        if ($request->filled('ph_max')) {
            $query->where('ph_value', '<=', (float) $request->input('ph_max'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date('date_to'));
        }

        return $query;
    }
}
