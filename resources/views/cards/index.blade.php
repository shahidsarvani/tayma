@extends('layout.app')

@section('title')
    RFID Card List
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">RFID Card List</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Token ID</th>
                        <th>Screen</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!$cards->isEmpty())
                        @foreach ($cards as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->card_id }}</td>
                                <td>{{ $item->screen->name_en }}</td>
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
                                            <a href="{{ route('cards.edit', $item->id) }}" class="list-icons-item text-primary"><i
                                                    class="icon-pencil7"></i></a>
                                        @endcan
                                        @can('delete-screen')
                                            <a href="{{ route('cards.destroy', $item->id) }}"
                                                class="list-icons-item text-danger"
                                                onclick="event.preventDefault(); document.getElementById('my-form{{ $item->id }}').submit();"><i
                                                    class="icon-trash"></i></a>
                                            <form action="{{ route('cards.destroy', $item->id) }}" method="post"
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
