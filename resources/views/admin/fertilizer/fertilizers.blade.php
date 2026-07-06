@extends('admin.layout')

@section('title', 'Fertilizer Master Data')
@section('subtitle', 'Manage general demonstration fertilizer records used by the rule engine.')

@section('content')
    <section class="admin-card">
        <div class="admin-card__header">
            <div>
                <p>New Catalog Item</p>
                <h2>Add fertilizer</h2>
            </div>
            <span class="admin-badge admin-badge--green">Master Data</span>
        </div>

        @if ($errors->any())
            <div class="admin-form-errors">
                <strong>Please correct the following:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="admin-form-grid" method="POST" action="{{ route('admin.fertilizer.master.store') }}">
            @csrf
            <label class="admin-field">
                <span>Fertilizer Name</span>
                <input class="admin-input" name="name" value="{{ old('name') }}" placeholder="Example: Urea" required>
            </label>
            <label class="admin-field">
                <span>Fertilizer Type</span>
                <input class="admin-input" name="fertilizer_type" value="{{ old('fertilizer_type') }}" placeholder="Example: Nitrogen fertilizer" required>
            </label>

            <fieldset class="admin-fieldset admin-field--full">
                <legend>Nutrient Composition (%)</legend>
                <div class="admin-npk-grid">
                    <label class="admin-field">
                        <span>Nitrogen (N)</span>
                        <input class="admin-input" type="number" step="0.01" min="0" name="nutrient_n" value="{{ old('nutrient_n', 0) }}">
                    </label>
                    <label class="admin-field">
                        <span>Phosphorus (P)</span>
                        <input class="admin-input" type="number" step="0.01" min="0" name="nutrient_p" value="{{ old('nutrient_p', 0) }}">
                    </label>
                    <label class="admin-field">
                        <span>Potassium (K)</span>
                        <input class="admin-input" type="number" step="0.01" min="0" name="nutrient_k" value="{{ old('nutrient_k', 0) }}">
                    </label>
                </div>
            </fieldset>

            <label class="admin-field">
                <span>Status</span>
                <select class="admin-input" name="status">
                    <option value="active" @selected(old('status', 'active') === 'active')>Active</option>
                    <option value="inactive" @selected(old('status') === 'inactive')>Inactive</option>
                </select>
            </label>
            <label class="admin-check admin-check--card">
                <input type="checkbox" name="organic" value="1" @checked(old('organic'))>
                <span>
                    <strong>Organic fertilizer</strong>
                    <small>Mark this product as organic.</small>
                </span>
            </label>

            <label class="admin-field admin-field--full">
                <span>Description</span>
                <textarea class="admin-input admin-textarea" name="description" placeholder="What this fertilizer provides and where it is commonly used." required>{{ old('description') }}</textarea>
            </label>
            <label class="admin-field">
                <span>Application Guidance</span>
                <textarea class="admin-input admin-textarea" name="application_guidance" placeholder="General timing and application guidance.">{{ old('application_guidance') }}</textarea>
            </label>
            <label class="admin-field">
                <span>Safety Warnings</span>
                <textarea class="admin-input admin-textarea" name="warnings" placeholder="Over-application, mixing, handling, or weather warnings.">{{ old('warnings') }}</textarea>
            </label>

            <div class="admin-form-actions admin-field--full">
                <p>Catalog entries are used by the fertilizer recommendation rule engine.</p>
                <button class="admin-button admin-button--primary" type="submit">Add Fertilizer</button>
            </div>
        </form>
    </section>

    <section class="admin-card">
        <div class="admin-card__header">
            <div><p>Catalog</p><h2>Fertilizer products</h2></div>
            <span class="admin-badge admin-badge--blue">{{ $fertilizers->total() }} products</span>
        </div>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead><tr><th>Name</th><th>Type</th><th>NPK</th><th>Organic</th><th>Status</th><th>Action</th></tr></thead>
                <tbody>
                    @foreach ($fertilizers as $fertilizer)
                        <tr>
                            <td>{{ $fertilizer->name }}</td>
                            <td>{{ $fertilizer->fertilizer_type }}</td>
                            <td>{{ $fertilizer->nutrient_n }}/{{ $fertilizer->nutrient_p }}/{{ $fertilizer->nutrient_k }}</td>
                            <td>{{ $fertilizer->organic ? 'Yes' : 'No' }}</td>
                            <td><span class="admin-badge {{ $fertilizer->status === 'active' ? 'admin-badge--green' : 'admin-badge--orange' }}">{{ ucfirst($fertilizer->status) }}</span></td>
                            <td>
                                <form method="POST" action="{{ route('admin.fertilizer.master.status', $fertilizer) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="admin-button admin-button--ghost" type="submit">Toggle</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $fertilizers->links('vendor.pagination.admin') }}
    </section>
@endsection
