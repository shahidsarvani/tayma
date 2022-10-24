@extends('layout.app')

@section('title')
    Add Hardware Schedule
@endsection

@section('header_scripts')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Hardware Schedule List</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
{{--                    <th>Hardware</th>--}}
                    <th>Day</th>
                    <th>Time</th>
                    <th>Action</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if (!$hardware_schedule->isEmpty())
                    @foreach ($hardware_schedule as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
{{--                            <td>{{ $item->hardware->name }}</td>--}}
                            <td>{{ $days[$item->day] }}</td>
                            <td>{{ $item->time }}</td>
                            {{--                                <td>{{ $item->app_path }}</td>--}}
                            <td>{{ $item->action }}</td>
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
                                        <a href="{{ route('schedule.edit', $item->id) }}" class="list-icons-item text-primary"><i
                                                    class="icon-pencil7"></i></a>
                                    @endcan
                                    @can('delete-hardware')
                                        <a href="{{ route('schedule.destroy', $item->id) }}"
                                           class="list-icons-item text-danger"
                                           onclick="event.preventDefault(); document.getElementById('my-form{{ $item->id }}').submit();"><i
                                                    class="icon-trash"></i></a>
                                        <form action="{{ route('schedule.destroy', $item->id) }}" method="post"
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
    </div>@endsection

@section('footer_scripts')

@endsection
