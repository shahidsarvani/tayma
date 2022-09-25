@extends('layout.app')

@section('title')
    Permission List
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Permission List</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Roles</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($permissions->isNotEmpty())
                        @php
                            $numbering = ($permissions->currentPage() - 1) * 10;
                        @endphp
                        @foreach ($permissions as $item)
                            <tr>
                                <td>{{ $loop->iteration + $numbering }}</td>
                                <td>{{ $item->name }}</td>
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
                                        @can('edit-permission')
                                            <a href="{{ route('permissions.edit', $item->id) }}"
                                                class="list-icons-item text-primary"><i class="icon-pencil7"></i></a>
                                        @endcan
                                        @can('delete-permission')
                                            <a href="{{ route('permissions.destroy', $item->id) }}"
                                                class="list-icons-item text-danger"
                                                onclick="event.preventDefault(); document.getElementById('my-form{{ $item->id }}').submit();"><i
                                                    class="icon-trash"></i></a>
                                            <form action="{{ route('permissions.destroy', $item->id) }}" method="post"
                                                id="my-form{{ $item->id }}" class="d-none">
                                                @csrf
                                                @method('delete')
                                            </form>
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
    {{ $permissions->links('vendor.pagination.theme') }}
@endsection
