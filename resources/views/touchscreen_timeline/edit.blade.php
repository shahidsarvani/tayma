@extends('layout.app')

@section('title')
    Edit Touchtable Timeline Item
@endsection

@section('header_scripts')
    <script src="{{ asset('assets/global_assets/js/plugins/editors/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/demo_pages/editor_ckeditor_material.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/plugins/uploaders/dropzone.min.js') }}"></script>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Edit Touchtable Timeline Item</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('touchtable.timeline.update', $timeline_item->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Menu:</label>
                            <select name="menu_id" class="form-control" required>
                                <option value="">Select Menu</option>
                                @foreach ($menus as $item)
                                    <option value="{{ $item['id'] }}" @if ($timeline_item->menu_id == $item['id']) selected @endif>
                                        {{ $item['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Language</label>
                            <select id="lang" class="form-control" name="lang" required>
                                <option value="">Select Language</option>
                                <option value="ar" @if ($timeline_item->lang == 'ar') selected @endif>Arabic</option>
                                <option value="en" @if ($timeline_item->lang == 'en') selected @endif>English</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Title:</label>
                            <input type="text" name="title" id="title" class="form-control"
                                value="{{ $timeline_item->title }}" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Description:</label>
                            <textarea name="description" id="editor-full1" rows="4" cols="4" required>{{ $timeline_item->description }}</textarea>
                            @error('description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    @if ($media)
                        @foreach ($media as $item)
                            <div class="col-md-3">
                                @if ($item->type == 'image')
                                    <img src="{{ asset('storage/app/public//media/' . $item->name) }}" alt="Content" class="w-100">
                                @else
                                    <video src="{{ asset('storage/app/public//media/' . $item->name) }}" controls muted></video>
                                @endif
                            </div>
                        @endforeach
                    @endif
                    <ul id="file-upload-list2" class="list-unstyled">
                    </ul>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Update <i class="icon-add ml-2"></i></button>
                </div>
                <form action="{{ route('touchtable.media.upload') }}" class="dropzone mt-3" id="dropzone_multiple">
                </form>

                <ul id="file-upload-list" class="list-unstyled">
                </ul>
            </form>
            <form action="{{ route('touchtable.media.upload') }}" class="dropzone mt-3" id="dropzone_multiple">
            </form>

            <ul id="file-upload-list" class="list-unstyled">
            </ul>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script>
        var list = $('#file-upload-list');
        var list2 = $('#file-upload-list2');
        console.log(list)
        // Multiple files
        Dropzone.options.dropzoneMultiple = {
            paramName: "media", // The name that will be used to transfer the file
            dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
            maxFilesize: 1024, // MB
            addRemoveLinks: true,
            chunking: true,
            chunkSize: 2000000,
            // If true, the individual chunks of a file are being uploaded simultaneously.
            parallelChunkUploads: true,
            acceptedFiles: 'video/*, image/*',
            init: function() {
                this.on('addedfile', function() {
                        list.append('<li>Uploading</li>')
                    }),
                    this.on('sending', function(file, xhr, formData) {
                        formData.append("_token", "{{ csrf_token() }}");

                        // This will track all request so we can get the correct request that returns final response:
                        // We will change the load callback but we need to ensure that we will call original
                        // load callback from dropzone
                        var dropzoneOnLoad = xhr.onload;
                        xhr.onload = function(e) {
                            dropzoneOnLoad(e)
                            // Check for final chunk and get the response
                            var uploadResponse = JSON.parse(xhr.responseText)
                            if (typeof uploadResponse.name === 'string') {
                                list.append('<li>Uploaded: ' + uploadResponse.path + uploadResponse.name +
                                    '</li>')
                                list2.append('<input type="hidden" name="file_names[]" value="' +
                                    uploadResponse.name +
                                    '" ><input type="hidden" name="types[]" value="' +
                                    uploadResponse.type + '" >')
                            }
                        }
                    })
            }
        };
    </script>
@endsection
