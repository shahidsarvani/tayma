@extends('layout.app')

@section('title')
    Add Slide
@endsection

@section('header_scripts')
    <script src="{{ asset('assets/global_assets/js/plugins/editors/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/demo_pages/editor_ckeditor_material.js') }}"></script>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Add Slide</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('slides.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Image (English):</label>
                            <label class="custom-file">
                                <input type="file" class="custom-file-input @error('image_en') is-invalid @enderror" name="image_en" accept="image/*" required>
                                <span class="custom-file-label">Choose file</span>
                            </label>
                            <span class="form-text text-muted">Accepted formats: gif, png, jpg. Max size: 2MB.</span>
                            <span class="form-text text-muted image_en_name"></span>
                            @error('image_en')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Content (English):</label>
                            <textarea name="content_en" id="editor-full1" rows="4" cols="4" required></textarea>
                            @error('content_en')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Image (Arabic):</label>
                            <label class="custom-file">
                                <input type="file" class="custom-file-input @error('image_en') is-invalid @enderror" name="image_ar" accept="image/*" required>
                                <span class="custom-file-label">Choose file</span>
                            </label>
                            <span class="form-text text-muted">Accepted formats: gif, png, jpg. Max size: 2MB.</span>
                            <span class="form-text text-muted image_ar_name"></span>
                            @error('image_ar')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Content (Arabic):</label>
                            <textarea name="content_ar" id="editor-full2" rows="4" cols="4" required></textarea>
                            @error('content_ar')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Sort Order:</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" name="sort_order" required>
                            @error('sort_order')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>RFID Card Token:</label>
                            <select name="rfid_card_id" class="form-control @error('rfid_card_id') is-invalid @enderror" required>
                                <option value="">Select RFID Card</option>
                                @foreach ($cards as $card)
                                    <option value="{{ $card->id }}">{{ $card->card_id }}</option>
                                @endforeach
                            </select>
                            @error('rfid_card_id')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status:</label>
                            <select name="is_active" class="form-control @error('is_active') is-invalid @enderror" required>
                                <option value="">Select Option</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @error('is_active')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
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
        $(document).ready(function() {
            $('input[type="file"]').change(function(e) {
                var input = e.target;
                var imageName = input.files[0]?.name
                if (imageName !== "") {
                    $('.' + input.name + "_name").html(imageName)
                }
            });
        })
    </script>
@endsection
