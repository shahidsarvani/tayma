@extends('layout.app')

@section('title')
    Add Hardware Schedule
@endsection

@section('header_scripts')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Add Hardware Schedule</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('schedule.update', $schedule->id) }}" method="post">
                @csrf
                @method('PUT')

                <div class="col-md-12 schedule_item">
                    <div class="row">
{{--                        <div class="col-md-6">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="hardware_id">Hardware:</label>--}}
{{--                                <select id="hardware_id" name="hardware_id" class="form-control" required>--}}
{{--                                    <option value="">Select Hardware</option>--}}
{{--                                    @foreach ($hardware as $key => $hard)--}}
{{--                                        <option @if($schedule->hardware_id == $hard->id) selected @endif value="{{ $hard->id }}">{{ $hard->name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Day:</label>
                                <select name="day" class="form-control" required>
                                    <option value="">Select Option</option>
                                    @foreach ($days as $key => $day)
                                        <option @if($schedule->day == $key) selected @endif value="{{ $key }}">{{ $day }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Time:</label>
                                <input type="time" class="form-control" name="time" required value="{{$schedule->time}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Action:</label>
                                <select name="action" class="form-control" required>
                                    <option value="">Select Action</option>
                                    <option @if($schedule->action == 'wakeup') selected @endif value="wakeup">WakeUp</option>
                                    <option @if($schedule->action == 'shutdown') selected @endif value="shutdown">Shutdown</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status:</label>
                                <select name="is_active" class="form-control" required>
                                    <option value="">Select Option</option>
                                    <option @if($schedule->is_active == 0) selected @endif value="0">Inactive</option>
                                    <option @if($schedule->is_active == 1) selected @endif value="1">Active</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-success" id="add_schedule_item">Update Schedule Time</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script>
        var html_text = `<div class="col-md-12 schedule_item">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Day:</label>
                                    <select name="day" class="form-control" required>
                                        <option value="">Select Option</option>
                                        @foreach ($days as $key => $day)
        <option value="{{ $key }}">{{ $day }}</option>
                                        @endforeach
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label>Start Time:</label>
        <input type="time" class="form-control" name="start_time" required>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label>End Time:</label>
        <input type="time" class="form-control" name="end_time" required>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label>Status:</label>
        <select name="day_is_active" class="form-control" required>
            <option value="">Select Option</option>
            <option value="0">Inactive</option>
            <option value="1">Active</option>
        </select>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="">&nbsp;</label>
        <button type="button" class="btn btn-danger form-control" onclick="deleteItem(this)">Delete</button>
    </div>
</div>
</div>
</div>`
        // var addItemBtn = document.getElementById('add_schedule_item')
        //
        // addItemBtn.addEventListener('click', function() {
        //     $('.schedule_items').append(html_text)
        // })
        //
        // function deleteItem(elem) {
        //     $(elem).parents('.schedule_item').remove()
        // }
    </script>
@endsection
