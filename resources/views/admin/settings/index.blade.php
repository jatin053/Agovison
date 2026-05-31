@extends('layouts.app')

@php($pageTitle = 'Platform Settings')
@php($pageSubtitle = 'Manage public labels, defaults, and internal system configuration.')

@section('content')
    <div class="surface-card mb-4">
        <form action="{{ route('admin.settings.store') }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-3"><input class="form-control" name="group" placeholder="Group"></div>
            <div class="col-md-3"><input class="form-control" name="key" placeholder="Key"></div>
            <div class="col-md-3"><input class="form-control" name="label" placeholder="Label"></div>
            <div class="col-md-3"><input class="form-control" name="value" placeholder="Value"></div>
            <div class="col-md-2"><input class="form-control" name="type" value="text"></div>
            <div class="col-md-2"><select class="form-select" name="is_public"><option value="0">Private</option><option value="1">Public</option></select></div>
            <div class="col-md-2"><button class="btn btn-success w-100">Add setting</button></div>
        </form>
    </div>
    <div class="table-surface">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead><tr><th>Key</th><th>Group</th><th>Value</th><th>Visibility</th></tr></thead>
                <tbody>
                    @foreach($settings as $setting)
                        <tr>
                            <td>{{ $setting->key }}</td>
                            <td>{{ $setting->group }}</td>
                            <td>{{ $setting->value }}</td>
                            <td>{{ $setting->is_public ? 'Public' : 'Private' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $settings->links() }}</div>
@endsection
