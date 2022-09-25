@extends('layout.app')

@section('title')
    Add Screen
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Add Screen</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('screens.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Name (English):</label>
                            <input type="text" class="form-control" id="name" name="name_en" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Name (Arabic):</label>
                            <input type="text" class="form-control" name="name_ar" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Slug:</label>
                            <input type="text" class="form-control" id="slug" name="slug" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Screen Types</label>
                            <select id="screen_id" class="form-control" name="screen_type" required>
                                <option value="">Select Screen</option>
                                @isset($screenTypes)
                                    @foreach ($screenTypes as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                @endisset

                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Touchable:</label>
                            <select name="is_touch" class="form-control" required>
                                <option value="">Select Option</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>RFID Enabled:</label>
                            <select name="is_rfid" class="form-control" required>
                                <option value="">Select Option</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>3D Model:</label>
                            <select name="is_model" class="form-control" required>
                                <option value="">Select Option</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Add <i class="icon-add ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script>
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');

        nameInput.addEventListener('change', function() {
            var str = this.value;
            str = str.replace(/^\s+|\s+$/g, ''); // trim
            str = str.toLowerCase();
            str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                .replace(/\s+/g, '-') // collapse whitespace and replace by -
                .replace(/-+/g, '-'); // collapse dashes
            slugInput.value = str
        })
    </script>
@endsection
