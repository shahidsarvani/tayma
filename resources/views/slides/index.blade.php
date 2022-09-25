@extends('layout.app')

@section('title')
    Slide List
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Slide List</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>RFID Card Token</th>
                        <th>Image (English)</th>
                        <th>Image (Arabic)</th>
                        <th>Content (English)</th>
                        <th>Content (Arabic)</th>
                        <th>Sort Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!$slides->isEmpty())
                        @foreach ($slides as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->card->card_id }}</td>
                                <td>{{ $item->image_en }}</td>
                                <td>{{ $item->image_ar }}</td>
                                <td>{!! $item->content_en !!}</td>
                                <td>{!! $item->content_ar !!}</td>
                                <td>{{ $item->sort_order }}</td>
                                <td>
                                    @if ($item->is_active)
                                        <span class="badge badge-info">Active</span>
                                    @else
                                        <span class="badge badge-warning">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="list-icons">
                                        @can('edit-screen')
                                            <a href="{{ route('slides.edit', $item->id) }}" class="list-icons-item text-primary"><i
                                                    class="icon-pencil7"></i></a>
                                        @endcan
                                        @can('delete-screen')
                                            <a href="{{ route('slides.destroy', $item->id) }}"
                                                class="list-icons-item text-danger"
                                                onclick="event.preventDefault(); document.getElementById('my-form{{ $item->id }}').submit();"><i
                                                    class="icon-trash"></i></a>
                                            <form action="{{ route('slides.destroy', $item->id) }}" method="post"
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
