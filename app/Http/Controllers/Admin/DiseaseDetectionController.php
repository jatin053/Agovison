<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiseaseDetection;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class DiseaseDetectionController extends Controller
{
    public function index(Request $request): View
    {
        $query = DiseaseDetection::query()->with('user')->latest();

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($builder) use ($search) {
                $builder->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%');
                })->orWhere('crop_name', 'like', '%'.$search.'%')
                    ->orWhere('disease_name', 'like', '%'.$search.'%')
                    ->orWhere('location', 'like', '%'.$search.'%');
            });
        }

        if ($request->filled('severity')) {
            $query->where('severity', $request->string('severity')->toString());
        }

        if ($request->filled('confidence_min')) {
            $query->where('confidence', '>=', (float) $request->input('confidence_min'));
        }

        if ($request->filled('confidence_max')) {
            $query->where('confidence', '<=', (float) $request->input('confidence_max'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date('date_to'));
        }

        $records = $query->paginate(12)->withQueryString();

        return view('admin.disease.index', [
            'records' => $records,
            'summary' => [
                'total' => DiseaseDetection::count(),
                'high' => DiseaseDetection::where('confidence', '>=', 85)->count(),
                'possible' => DiseaseDetection::whereBetween('confidence', [60, 84.99])->count(),
                'low' => DiseaseDetection::where('confidence', '<', 60)->count(),
            ],
        ]);
    }

    public function show(DiseaseDetection $diseaseDetection): View
    {
        return view('admin.disease.show', [
            'record' => $diseaseDetection->load('user'),
        ]);
    }

    public function destroy(DiseaseDetection $diseaseDetection): RedirectResponse
    {
        Storage::disk('public')->delete($diseaseDetection->image_path ?: $diseaseDetection->leaf_image_path);
        $diseaseDetection->delete();

        return redirect()
            ->route('admin.disease.index')
            ->with('status', 'Disease record deleted.');
    }

    public function csv(Request $request): Response
    {
        $records = $this->filteredRecords($request);
        $lines = [
            ['ID', 'User Name', 'Email', 'Crop', 'Image', 'Disease', 'Confidence', 'Severity', 'Location', 'Date'],
        ];

        foreach ($records as $record) {
            $lines[] = [
                $record->id,
                $record->user?->name ?? 'Deleted user',
                $record->user?->email ?? 'N/A',
                $record->crop_name,
                $record->image_path ?: $record->leaf_image_path,
                $record->disease_name,
                number_format((float) $record->confidence, 2),
                $record->severity,
                $record->location,
                $record->created_at?->format('M d, Y'),
            ];
        }

        $csv = '';

        foreach ($lines as $line) {
            $csv .= collect($line)->map(fn ($cell) => '"'.str_replace('"', '""', (string) $cell).'"')->implode(',')."\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="disease-records.csv"',
        ]);
    }

    private function filteredRecords(Request $request)
    {
        $query = DiseaseDetection::query()->with('user')->latest();

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($builder) use ($search) {
                $builder->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%');
                })->orWhere('crop_name', 'like', '%'.$search.'%')
                    ->orWhere('disease_name', 'like', '%'.$search.'%')
                    ->orWhere('location', 'like', '%'.$search.'%');
            });
        }

        if ($request->filled('severity')) {
            $query->where('severity', $request->string('severity')->toString());
        }

        if ($request->filled('confidence_min')) {
            $query->where('confidence', '>=', (float) $request->input('confidence_min'));
        }

        if ($request->filled('confidence_max')) {
            $query->where('confidence', '<=', (float) $request->input('confidence_max'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date('date_to'));
        }

        return $query->get();
    }
}
