<section class="dash-card">
    <div class="dash-card__header">
        <div>
            <p class="dash-eyebrow">Saved Records</p>
            <h2>Recent activity</h2>
        </div>
    </div>

    <div class="dash-table-wrap">
        <table class="dash-table">
            <thead>
                <tr>
                    @foreach ($columns as $label)
                        <th>{{ $label }}</th>
                    @endforeach
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($records as $record)
                    <tr>
                        @foreach ($columns as $field => $label)
                            <td>{{ $record->{$field} ?? 'N/A' }}{{ $field === 'confidence_score' ? '%' : '' }}</td>
                        @endforeach
                        <td>{{ $record->created_at?->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) + 1 }}">No records saved yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
