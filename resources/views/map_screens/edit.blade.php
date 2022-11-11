@extends('layout.app')

@section('title')
    Edit Map Screen
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Edit Map Screen</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('map.screens.update', $screen->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name (English):</label>
                            <input type="text" class="form-control" name="name_en" id="name" value="{{$screen->name_en}}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name (Arabic):</label>
                            <input type="text" class="form-control" name="name_ar" value="{{$screen->name_ar}}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Slug:</label>
                            <input type="text" class="form-control" id="slug" name="slug" value="{{ $screen->slug }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Interactive:</label>
                            <select id="is_touch" name="is_touch" class="custom-select">
                                <option @if($screen->is_touchable === 0) selected @endif value="0">Non Interactive</option>
                                <option @if($screen->is_touchable === 1) selected @endif value="1">Interactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Update <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script>
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');

        nameInput.addEventListener('input', function() {
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
