@extends('admin.layout')

@section('title', 'Fertilizer Rules')
@section('subtitle', 'Manage basic nutrient-deficiency rules. Demo data is not complete agricultural advice.')

@section('content')
    <section class="admin-card">
        <form class="admin-filters" method="POST" action="{{ route('admin.fertilizer.rules.store') }}">
            @csrf
            <select class="admin-input" name="fertilizer_id" required><option value="">Fertilizer</option>@foreach ($fertilizers as $fertilizer)<option value="{{ $fertilizer->id }}">{{ $fertilizer->name }}</option>@endforeach</select>
            <input class="admin-input" name="nutrient_type" placeholder="nitrogen/phosphorus/potassium" required>
            <input class="admin-input" name="nutrient_condition" placeholder="low/medium/high" required>
            <input class="admin-input" name="problem" placeholder="Problem optional">
            <input class="admin-input" name="growth_stage" placeholder="Growth stage optional">
            <input class="admin-input" type="number" name="priority" value="10" required>
            <select class="admin-input" name="status"><option>active</option><option>inactive</option></select>
            <textarea class="admin-input" name="reason" placeholder="Reason" required></textarea>
            <textarea class="admin-input" name="general_guidance" placeholder="General guidance"></textarea>
            <textarea class="admin-input" name="warning" placeholder="Warning"></textarea>
            <button class="admin-button admin-button--primary" type="submit">Add Rule</button>
        </form>
    </section>

    <section class="admin-card">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead><tr><th>Fertilizer</th><th>Nutrient</th><th>Condition</th><th>Problem</th><th>Priority</th><th>Status</th><th>Reason</th></tr></thead>
                <tbody>
                    @foreach ($rules as $rule)
                        <tr><td>{{ $rule->fertilizer?->name }}</td><td>{{ $rule->nutrient_type }}</td><td>{{ $rule->nutrient_condition }}</td><td>{{ $rule->problem ?: 'Any' }}</td><td>{{ $rule->priority }}</td><td>{{ $rule->status }}</td><td>{{ $rule->reason }}</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $rules->links('vendor.pagination.admin') }}
    </section>
@endsection
