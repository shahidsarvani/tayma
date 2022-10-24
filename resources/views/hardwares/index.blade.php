@extends('layout.app')

@section('title')
    Hardware List
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Hardware List</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>IP</th>
                        <th>MAC Address</th>
{{--                        <th>App Path</th>--}}
                        <th>Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!$hardwares->isEmpty())
                        @foreach ($hardwares as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->ip }}</td>
                                <td>{{ $item->mac_address }}</td>
{{--                                <td>{{ $item->app_path }}</td>--}}
                                <td>{{ $item->type }}</td>
                                <td>
                                    @if ($item->is_active)
                                        <span class="badge badge-info">Active</span>
                                    @else
                                        <span class="badge badge-warning">In active</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="list-icons">
                                        @can('edit-hardware')
                                            <a href="{{ route('hardwares.edit', $item->id) }}" class="list-icons-item text-primary"><i
                                                    class="icon-pencil7"></i></a>
                                        @endcan
                                        @can('delete-hardware')
                                            <a href="{{ route('hardwares.destroy', $item->id) }}"
                                                class="list-icons-item text-danger"
                                                onclick="event.preventDefault(); document.getElementById('my-form{{ $item->id }}').submit();"><i
                                                    class="icon-trash"></i></a>
                                            <form action="{{ route('hardwares.destroy', $item->id) }}" method="post"
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
                            <td colspan="7">No record found!</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
