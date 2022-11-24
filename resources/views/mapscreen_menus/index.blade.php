@extends('layout.app')

@section('title')
    Map Screen Menu List
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Map Screen Menu List</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name (English)</th>
                        <th>Name (Arabic)</th>
                        <th>Screen</th>
                        <th>Parent Menu</th>
                        <th>Menu Level</th>
                        <th>Type</th>
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
                                <td>{{ $item->screen->name_en }}</td>
                                <td>
                                    @if ($item->parent)
                                        <span class="badge badge-info">{{ $item->parent->name_en }}</span>
                                    @else
                                        <span class="badge badge-warning">NA</span>
                                    @endif
                                </td>
                                <td>{{ $item->level }}</td>
                                <td>{{ ucfirst($item->type) }}</td>
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
                                        @can('edit-map-screen-menu')
                                            <a href="{{ route('map.menus.edit', $item->id) }}" class="list-icons-item text-primary"><i
                                                    class="icon-pencil7"></i></a>
                                        @endcan
                                        @can('delete-map-screen-menu')
                                            <a href="{{ route('map.menus.destroy', $item->id) }}"
                                                class="list-icons-item text-danger"
                                                onclick="event.preventDefault(); document.getElementById('my-form{{ $item->id }}').submit();"><i
                                                    class="icon-trash"></i></a>
                                            <form action="{{ route('map.menus.destroy', $item->id) }}" method="post"
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
                            <td colspan="10">No record found!</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
