@extends('layout.app')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h4>Dashboard</h4>
        </div>
        @can('edit-logo')
            <div class="col-md-6">
                <form action="{{ route('settings.change_logo') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Logo:</label>
                        <label class="custom-file">
                            <input type="file" onchange="readURL(this);"
                                class="custom-file-input @error('logo') is-invalid @enderror" name="logo" accept="image/*"
                                required>
                            <span class="custom-file-label">Choose file</span>
                        </label>
                        <span class="form-text text-muted">Accepted formats: png, jpg. Max size: 2MB.</span>
                        <img class="site_logo" width="100%"
                            src="{{ $logo ? asset('public/storage/media/' . $logo->value) : '' }}">
                        <span class="form-text text-muted logo_name"></span>
                        @error('logo')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Change Logo <i class="icon-add ml-2"></i></button>
                    </div>
                </form>
            </div>
        @endcan
    </div>
    <div class="row">

    </div>
@endsection

@section('footer_scripts')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.site_logo').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
