@extends('layout.app')

<style>

    .image-area {
        position: absolute;
        width: 100px;
    }

    .image-area img {
        max-width: 100px;
        height: auto;
    }

    .remove-image {
        display: none;
        position: absolute;
        top: -10px;
        /*right: -10px;*/
        border-radius: 10em;
        padding: 2px 6px 3px;
        text-decoration: none;
        font: 700 21px/20px sans-serif;
        background: #555;
        border: 3px solid #fff;
        color: #fff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.5), inset 0 2px 4px rgba(0, 0, 0, 0.3);
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        -webkit-transition: background 0.5s;
        transition: background 0.5s;
    }

    .remove-image:hover {
        background: #e54e4e;
        padding: 3px 7px 5px;
        top: -11px;
        /*right: -11px;*/
    }

    .remove-image:active {
        background: #e54e4e;
        top: -10px;
        /*right: -11px;*/
    }

    .image-area- img, .image-area- video, .image-area- {
        width: 100px;
    }
</style>

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
                                   class="custom-file-input @error('logo') is-invalid @enderror" name="logo"
                                   accept="image/*"
                                   required>
                            <span class="custom-file-label">Choose file</span>
                        </label>
                        <span class="form-text text-muted">Accepted formats: png, jpg. Max size: 2MB.</span>
                        <div class="col-md-6">
                            <div class="image-area">
                                @if($logo)
                                <img class="site_logo" width="100%"
                                     src="{{ $logo ? asset('/storage/app/public/media/' . $logo->value) : '' }}">
                                <a class="remove-image" href="{{ route('settings.remove.logo', $logo->id) }}"
                                   style="display: inline;">&#215;</a>
                                    @endif
                            </div>
                        </div>
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
                reader.onload = function (e) {
                    $('.site_logo').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
