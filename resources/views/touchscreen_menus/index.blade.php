@extends('layout.app')

@section('title')
    Menu List
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Touchtable Menu List</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name (English)</th>
                        <th>Name (Arabic)</th>
                        <th>Timeline</th>
                        <th>Parent Menu</th>
                        <th>Menu Level</th>
                        <th>Type</th>
{{--                        <th>Screen Type</th>--}}
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!$menus->isEmpty())
                        @foreach ($menus as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name_en }}</td>
                                <td>{{ $item->name_ar }}</td>
                                <td>{{ $item->is_timeline }}</td>
                                <td>
                                    @if ($item->parent)
                                        <span class="badge badge-info">{{ $item->parent->name_en }}</span>
                                    @else
                                        <span class="badge badge-warning">NA</span>
                                    @endif
                                </td>
                                <td>{{ $item->level }}</td>
                                <td>{{ ucfirst($item->type) }}</td>
{{--                                <td>{{ $item->screen_type }}</td>--}}
                                <td>{{ $item->order }}</td>
                                <td>
                                    @if ($item->is_active)
                                        <span class="badge badge-info">Active</span>
                                    @else
                                        <span class="badge badge-warning">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="list-icons">
                                        @can('edit-touchtable-screen-menu')
                                            <a href="{{ route('touchtable.menus.edit', $item->id) }}" class="list-icons-item text-primary"><i
                                                    class="icon-pencil7"></i></a>
                                        @endcan
                                        @can('delete-touchtable-screen-menu')
                                            <a href="{{ route('touchtable.menus.destroy', $item->id) }}"
                                                class="list-icons-item text-danger"
                                                onclick="event.preventDefault(); document.getElementById('my-form{{ $item->id }}').submit();"><i
                                                    class="icon-trash"></i></a>
                                            <form action="{{ route('touchtable.menus.destroy', $item->id) }}" method="post"
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
                            <td colspan="9">No record found!</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
