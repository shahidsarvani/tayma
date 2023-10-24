@extends('layout.app')

<style type="text/css">
    @font-face {
        src: url('{{asset('/storage/app/public/fonts/' . $logo['heading_fonts_en']['value'])}}');
    }

</style>

@section('title')
    Fonts
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h4>Fonts</h4>
        </div>
        @can('edit-logo')
            <div class="col-md-6">
                <form action="{{ route('settings.change_fonts') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Heading Font English:</label>
                        <label class="custom-file">
                            <input type="file"
                                   class="custom-file-input @error('heading_fonts_en') is-invalid @enderror"
                                   name="heading_fonts_en"
                                   >
                            <span class="custom-file-label">Choose file</span>
                        </label>
                        <div class="col-md-6">
                            <div class="image-area">
                                @if($logo['body_fonts_en'])
                                    <a href="">{{asset('/storage/app/public/fonts/' . $logo['heading_fonts_en']['value'])}}</a>
                                @endif
                            </div>
                        </div>
                        <span class="form-text text-muted logo_name"></span>
                        @error('heading_fonts_en')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Body Font English:</label>
                        <label class="custom-file">
                            <input type="file"
                                   class="custom-file-input @error('body_fonts_en') is-invalid @enderror"
                                   name="body_fonts_en"
                                   >
                            <span class="custom-file-label">Choose file</span>
                        </label>
                        <div class="col-md-6">
                            <div class="image-area">
                                @if($logo['heading_fonts_ar'])
                                    <a href="">{{asset('/storage/app/public/fonts/' . $logo['body_fonts_en']['value'])}}</a>
                                @endif
                            </div>
                        </div>
                        <span class="form-text text-muted logo_name"></span>
                        @error('heading_fonts_ar')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>English Heading Fonts Arabic:</label>
                        <label class="custom-file">
                            <input type="file"
                                   class="custom-file-input @error('heading_fonts_ar') is-invalid @enderror"
                                   name="heading_fonts_ar"
                                   >
                            <span class="custom-file-label">Choose file</span>
                        </label>
                        <div class="col-md-6">
                            <div class="image-area">
                                @if($logo['heading_fonts_ar'])
                                    <a href="">{{asset('/storage/app/public/fonts/' . $logo['heading_fonts_ar']['value'])}}</a>
                                @endif
                            </div>
                        </div>
                        <span class="form-text text-muted logo_name"></span>
                        @error('body_fonts_ar')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Body Fonts Arabic:</label>
                        <label class="custom-file">
                            <input type="file"
                                   class="custom-file-input @error('body_fonts_ar') is-invalid @enderror"
                                   name="body_fonts_ar"
                                   >
                            <span class="custom-file-label">Choose file</span>
                        </label>
                        <div class="col-md-6">
                            <div class="image-area">
                                @if($logo['body_fonts_ar'])
                                    <a href="">{{asset('/storage/app/public/fonts/' . $logo['body_fonts_ar']['value'])}}</a>
                                @endif
                            </div>
                        </div>
                        <span class="form-text text-muted logo_name"></span>
                        @error('body_fonts_ar')
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
