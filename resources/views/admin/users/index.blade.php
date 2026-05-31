@extends('layouts.app')

@php($pageTitle = 'User Management')
@php($pageSubtitle = 'Manage roles, activate or block accounts, and keep the marketplace healthy.')

@section('content')
    <div class="table-surface">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead><tr><th>User</th><th>Role</th><th>Status</th><th>Phone</th><th>Actions</th></tr></thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $user->name }}</div>
                                <small class="muted-label">{{ $user->email }}</small>
                            </td>
                            <td>{{ $user->primaryRole() }}</td>
                            <td>{{ $user->is_blocked ? 'Blocked' : ucfirst($user->status) }}</td>
                            <td>{{ $user->phone }}</td>
                            <td class="text-end">
                                <form action="{{ route('admin.users.toggle-block', $user) }}" method="POST" class="d-inline">@csrf @method('PATCH')<button class="btn btn-outline-light btn-sm">{{ $user->is_blocked ? 'Unblock' : 'Block' }}</button></form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $users->links() }}</div>
@endsection
