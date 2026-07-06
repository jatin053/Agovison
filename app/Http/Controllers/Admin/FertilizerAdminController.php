<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fertilizer;
use App\Models\FertilizerRecommendation;
use App\Models\FertilizerRule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class FertilizerAdminController extends Controller
{
    public function fertilizers(): View
    {
        return view('admin.fertilizer.fertilizers', [
            'fertilizers' => Fertilizer::latest()->paginate(15),
        ]);
    }

    public function storeFertilizer(Request $request): RedirectResponse
    {
        Fertilizer::create($this->fertilizerData($request));

        return back()->with('status', 'Fertilizer saved.');
    }

    public function updateFertilizer(Request $request, Fertilizer $fertilizer): RedirectResponse
    {
        $fertilizer->update($this->fertilizerData($request));

        return back()->with('status', 'Fertilizer updated.');
    }

    public function deactivateFertilizer(Fertilizer $fertilizer): RedirectResponse
    {
        $fertilizer->update(['status' => $fertilizer->status === 'active' ? 'inactive' : 'active']);

        return back()->with('status', 'Fertilizer status changed.');
    }

    public function rules(): View
    {
        return view('admin.fertilizer.rules', [
            'rules' => FertilizerRule::with('fertilizer')->latest()->paginate(15),
            'fertilizers' => Fertilizer::where('status', 'active')->orderBy('name')->get(),
        ]);
    }

    public function storeRule(Request $request): RedirectResponse
    {
        FertilizerRule::create($this->ruleData($request));

        return back()->with('status', 'Rule saved.');
    }

    public function updateRule(Request $request, FertilizerRule $fertilizerRule): RedirectResponse
    {
        $fertilizerRule->update($this->ruleData($request));

        return back()->with('status', 'Rule updated.');
    }

    public function reports(Request $request): View
    {
        return view('admin.fertilizer.reports', [
            'records' => $this->reportQuery($request)->paginate(15)->withQueryString(),
            'filters' => $request->query(),
        ]);
    }

    public function showReport(FertilizerRecommendation $fertilizerRecommendation): View
    {
        return view('admin.fertilizer.show', [
            'record' => $fertilizerRecommendation->load('user', 'fertilizer', 'soilProfile'),
        ]);
    }

    public function reviewReport(Request $request, FertilizerRecommendation $fertilizerRecommendation): RedirectResponse
    {
        $data = $request->validate([
            'admin_note' => ['nullable', 'string', 'max:3000'],
            'admin_reviewed' => ['nullable', 'boolean'],
        ]);

        $fertilizerRecommendation->update([
            'admin_note' => $data['admin_note'] ?? null,
            'admin_reviewed' => (bool) ($data['admin_reviewed'] ?? false),
        ]);

        return back()->with('status', 'Recommendation reviewed.');
    }

    public function destroyReport(FertilizerRecommendation $fertilizerRecommendation): RedirectResponse
    {
        $fertilizerRecommendation->delete();

        return redirect()->route('admin.fertilizer.reports')->with('status', 'Recommendation deleted.');
    }

    public function csv(Request $request): Response
    {
        $handle = fopen('php://temp', 'w+');
        fputcsv($handle, ['ID', 'User', 'Email', 'Crop', 'Soil Type', 'NPK', 'Problem', 'Recommended Fertilizer', 'Confidence', 'Location', 'Reviewed', 'Date']);

        foreach ($this->reportQuery($request)->get() as $record) {
            fputcsv($handle, [
                $record->id,
                $record->user?->name,
                $record->user?->email,
                $record->crop_name,
                $record->soil_type,
                ($record->nitrogen_level ?: $record->nitrogen_value).'/'.($record->phosphorus_level ?: $record->phosphorus_value).'/'.($record->potassium_level ?: $record->potassium_value),
                $record->current_problem,
                $record->recommended_fertilizer_name ?: $record->recommended_fertilizer,
                $record->confidence,
                $record->location ?: $record->location_name,
                $record->admin_reviewed ? 'Yes' : 'No',
                optional($record->created_at)->format('Y-m-d H:i:s'),
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="fertilizer-recommendation-reports.csv"',
        ]);
    }

    private function reportQuery(Request $request)
    {
        $query = FertilizerRecommendation::with('user')->latest();

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($builder) use ($search) {
                $builder->where('crop_name', 'like', '%'.$search.'%')
                    ->orWhere('recommended_fertilizer_name', 'like', '%'.$search.'%')
                    ->orWhere('location', 'like', '%'.$search.'%')
                    ->orWhereHas('user', fn ($userQuery) => $userQuery->where('name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%'));
            });
        }

        if ($request->filled('soil_type')) {
            $query->where('soil_type', $request->string('soil_type')->toString());
        }
        if ($request->filled('reviewed')) {
            $query->where('admin_reviewed', $request->boolean('reviewed'));
        }
        if ($request->filled('confidence_min')) {
            $query->where('confidence', '>=', (float) $request->input('confidence_min'));
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date('date_to'));
        }

        return $query;
    }

    private function fertilizerData(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'fertilizer_type' => ['required', 'string', 'max:191'],
            'nutrient_n' => ['nullable', 'numeric', 'min:0'],
            'nutrient_p' => ['nullable', 'numeric', 'min:0'],
            'nutrient_k' => ['nullable', 'numeric', 'min:0'],
            'organic' => ['nullable', 'boolean'],
            'description' => ['required', 'string'],
            'application_guidance' => ['nullable', 'string'],
            'warnings' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $data['organic'] = (bool) ($data['organic'] ?? false);

        return $data;
    }

    private function ruleData(Request $request): array
    {
        return $request->validate([
            'crop_name' => ['nullable', 'string', 'max:191'],
            'soil_type' => ['nullable', 'string', 'max:80'],
            'season' => ['nullable', 'string', 'max:80'],
            'growth_stage' => ['nullable', 'string', 'max:80'],
            'nutrient_type' => ['required', 'string', 'max:80'],
            'nutrient_condition' => ['required', 'string', 'max:80'],
            'minimum_ph' => ['nullable', 'numeric', 'between:0,14'],
            'maximum_ph' => ['nullable', 'numeric', 'between:0,14'],
            'problem' => ['nullable', 'string', 'max:191'],
            'fertilizer_id' => ['required', 'exists:fertilizers,id'],
            'priority' => ['required', 'integer', 'min:0', 'max:100'],
            'reason' => ['required', 'string'],
            'general_guidance' => ['nullable', 'string'],
            'warning' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ]);
    }
}
