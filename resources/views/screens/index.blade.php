@extends('layout.app')

@section('title')
    Screen List
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Screen List</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name (English)</th>
                        <th>Name (Arabic)</th>
                        <th>Slug</th>
                        <th>Screen Type</th>
                        <th>RFID</th>
                        <th>Touchable</th>
                        <th>3D Model</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!$screens->isEmpty())
                        @foreach ($screens as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name_en }}</td>
                                <td>{{ $item->name_ar }}</td>
                                <td>{{ $item->slug !== '' ? $item->slug : 'N/A' }}</td>
                                <td>{{ $item->screen_type }}</td>
                                <td>
                                    @if ($item->is_rfid)
                                            <span class="badge badge-info">Yes</span>
                                    @else
                                        <span class="badge badge-warning">No</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->is_touch)
                                            <span class="badge badge-info">Yes</span>
                                    @else
                                        <span class="badge badge-warning">No</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->is_model)
                                            <span class="badge badge-info">Yes</span>
                                    @else
                                        <span class="badge badge-warning">No</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="list-icons">
                                        @can('edit-screen')
                                            <a href="{{ route('screens.edit', $item->id) }}" class="list-icons-item text-primary"><i
                                                    class="icon-pencil7"></i></a>
                                        @endcan
                                        @can('delete-screen')
                                            <a href="{{ route('screens.destroy', $item->id) }}"
                                                class="list-icons-item text-danger"
                                                onclick="event.preventDefault(); document.getElementById('my-form{{ $item->id }}').submit();"><i
                                                    class="icon-trash"></i></a>
                                            <form action="{{ route('screens.destroy', $item->id) }}" method="post"
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
