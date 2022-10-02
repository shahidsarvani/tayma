@extends('layout.app')

@section('title')
    Touchscreen Content List
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Touchscreen Content List</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Language</th>
                        <th>Menu</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!$content->isEmpty())
                        @foreach ($content as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{!! $item->description !!}</td>
                                <td>{{ $item->lang === 'en' ? 'English' : 'Arabic' }}</td>
                                <td>{{ $item->menu->name_en }}</td>
                                <td>
                                    <div class="list-icons">
                                        @can('edit-touchtable-timeline-item')
                                            <a href="{{ route('touchtable.timeline.edit', $item->id) }}" class="list-icons-item text-primary"><i
                                                    class="icon-pencil7"></i></a>
                                        @endcan
                                        @can('delete-touchtable-timeline-item')
                                            <a href="{{ route('touchtable.timeline.destroy', $item->id) }}"
                                                class="list-icons-item text-danger"
                                                onclick="event.preventDefault(); document.getElementById('my-form{{ $item->id }}').submit();"><i
                                                    class="icon-trash"></i></a>
                                            <form action="{{ route('touchtable.timeline.destroy', $item->id) }}" method="post"
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
                            <td colspan="5">No record found!</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
