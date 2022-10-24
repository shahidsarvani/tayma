@extends('layout.app')

@section('title')
    Add Hardware
@endsection

@section('header_scripts')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Add Hardware</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('hardwares.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name:</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>IP:</label>
                            <input type="text" class="form-control" name="ip" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>MAC Address:</label>
                            <input type="text" class="form-control" name="mac_address" required>
                        </div>
                    </div>
{{--                    <div class="col-md-6">--}}
{{--                        <div class="form-group">--}}
{{--                            <label>App Path:</label>--}}
{{--                            <input type="text" class="form-control" name="app_path" required>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Hardware Type:</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="">Select Option</option>
                                <option value="pc">PC</option>
                                <option value="screen">Screen</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status:</label>
                            <select name="is_active" id="is_active" class="form-control" required>
                                <option value="">Select Option</option>
                                <option value="0">Inactive</option>
                                <option value="1">Active</option>
                            </select>
                        </div>
                    </div>
                </div>
{{--                <div class="text-right">--}}
{{--                    <button type="button" class="btn btn-success" id="add_schedule_item">Add Schedule Time</button>--}}
{{--                </div>--}}
                <div class="row mb-3 schedule_items">
                    {{-- <div class="col-md-12 schedule_item">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Day:</label>
                                    <select name="day[]" class="form-control" required>
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
                                    <input type="text" class="form-control" name="start_time[]" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>End Time:</label>
                                    <input type="text" class="form-control" name="end_time[]" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Status:</label>
                                    <select name="day_is_active[]" class="form-control" required>
                                        <option value="">Select Option</option>
                                        <option value="0">Inactive</option>
                                        <option value="1">Active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">&nbsp;</label>
                                    <button type="button" class="btn btn-danger form-control" onclick="deleteItem(this)">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Add <i class="icon-add ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection

