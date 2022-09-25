@extends('layout.app')

@section('title')
    User List
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">User List</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role(s)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($users)
                        @foreach ($users as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    @if ($item->roles->pluck('name')->isNotEmpty())
                                        @foreach ($item->roles->pluck('name') as $role)
                                            <span class="badge badge-info">{{ $role }}</span>
                                        @endforeach
                                    @else
                                        <span class="badge badge-warning">NA</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="list-icons">
                                        @can('edit-user')
                                            <a href="{{ route('users.edit', $item->id) }}" class="list-icons-item text-primary"><i
                                                    class="icon-pencil7"></i></a>
                                        @endcan
                                        @can('delete-user')
                                            @if (auth()->user()->id !== $item->id || !$item->hasRole('superadmin'))
                                                <a href="{{ route('users.destroy', $item->id) }}"
                                                    class="list-icons-item text-danger"
                                                    onclick="event.preventDefault(); document.getElementById('my-form{{ $item->id }}').submit();"><i
                                                        class="icon-trash"></i></a>
                                                <form action="{{ route('users.destroy', $item->id) }}" method="post"
                                                    id="my-form{{ $item->id }}" class="d-none">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            @endif
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4">No record found!</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
