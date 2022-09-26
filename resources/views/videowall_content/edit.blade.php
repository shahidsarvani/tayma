@extends('layout.app')

@section('title')
    Edit Videowall Content
@endsection

@section('header_scripts')
    <script src="{{ asset('assets/global_assets/js/plugins/editors/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/demo_pages/editor_ckeditor_material.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/plugins/uploaders/dropzone.min.js') }}"></script>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Edit Videowall Content</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('videowall.content.update', $content->id) }}" method="post">
                @csrf
                @method('patch')
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Language</label>
                            <select id="lang" class="form-control" name="lang" required>
                                <option value="">Select Language</option>
                                <option value="ar" @if ($content->lang == 'ar') selected @endif>Arabic</option>
                                <option value="en" @if ($content->lang == 'en') selected @endif>English</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Screen:</label>
                            <select name="screen_id" id="screen_id" class="form-control">
                                <option value="">Select Screen</option>
                                @foreach ($screens as $item)
                                    <option value="{{ $item->id }}" @if ($content->screen_id == $item->id) selected @endif>
                                        {{ $item->name_en }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Menu</label>
                            <select name="menu_id" id="menu_id" class="form-control" required>
                                <option value="">Select Menu</option>
                                @foreach ($menus as $item)
                                    <option value="{{ $item['id'] }}" @if ($content->menu_id == $item['id']) selected @endif>
                                        {{ $item['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Content:</label>
                            <textarea name="content" id="editor-full1" rows="4" cols="4" required>{{ $content->content }}</textarea>
                            @error('content')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    @if ($media)
                    @foreach ($media as $item)
                    <div class="col-md-3">
                        @if ($item->type == 'image')
                            <img src="{{ asset('storage/app/public/media/' . $item->name) }}" alt="Content">
                        @else
                            <video src="{{ asset('storage/app/public/media/' . $item->name) }}" controls muted></video>
                        @endif
                    </div>
                    @endforeach
                    @endif
                    <ul id="file-upload-list2" class="list-unstyled">
                    </ul>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
            <form action="{{ route('videowall.media.upload') }}" class="dropzone mt-3" id="dropzone_multiple">
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

        $('#screen_id').change(function() {
            screen_id = this.value | 0
            var url = "../getscreensidemenu/" + screen_id
            console.log(url)
            $.ajax({
                url: url,
                method: 'get',
                dataType: 'json',
                success: function(response) {
                    var html_text = '<option value="">Select Menu *</option>'
                    if (response.length) {
                        for (var i = 0; i < response.length; i++) {
                            html_text += '<option value="' + response[i].id + '">' + response[i].name +
                                '</option>'
                        }
                    }
                    $('#menu_id').empty().append(html_text);
                }
            })
        })
    </script>
@endsection
