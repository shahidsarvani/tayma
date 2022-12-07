@extends('layout.app')

@section('title', 'Add Video Screen Media')
@section('header_scripts')
    <script src="{{ asset('assets/global_assets/js/plugins/uploaders/dropzone.min.js') }}"></script>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Add Video Screen Media</h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Language *</label>
                                <select id="lang" class="form-control" required>
                                    <option value="">Select Language</option>
                                    <option value="ar">Arabic</option>
                                    <option value="en">English</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Screen *</label>
                                <select id="screen_id" class="form-control" required>
                                    <option value="">Select Screen</option>
                                    @foreach ($screens as $item)
                                        <option value="{{ $item->slug }}">{{ $item->name_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Upload Media:</label>
                        {{-- <input type="file" name="media" class="file-input-ajax" accept="video/*" multiple="multiple" data-fouc> --}}
                        <form action="{{ route('portrait.media.upload') }}" class="dropzone" id="dropzone_multiple">
                        </form>

                    </div>
                    <form action="{{ route('portrait.media.store') }}" method="post" id="mediaForm">
                            @csrf
                            <ul id="file-upload-list" class="list-unstyled">
                            </ul>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary add_media">Add <i
                                class="icon-plus-circle2 ml-2"></i></button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script>
        var err = 0;
        $('.add_media').click(function(e) {
            e.preventDefault();
            var form = document.getElementById('mediaForm')
            if (!$('input[name=lang]').length) {
                err = 1;
            }
            if (!$('input[name=screen_id]').length) {
                err = 1;
            }
            if (!err) {
                form.submit();
            } else {
                alert('Please complete required fields')
            }
        })
        var list = $('#file-upload-list');
        // Multiple files
        Dropzone.options.dropzoneMultiple = {
            parallelUploads: 1,
            paramName: "media", // The name that will be used to transfer the file
            dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
            maxFilesize: 204800, // MB
            addRemoveLinks: true,
            chunking: true,
            chunkSize: 2000000,
            // If true, the individual chunks of a file are being uploaded simultaneously.
            parallelChunkUploads: false,
            acceptedFiles: 'video/*',
            retryChunks: true,   // retry chunks on failure
            retryChunksLimit: 3, // retry maximum of 3 times (default is 3)
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
                                    '</li><input type="hidden" name="file_names[]" value="' +
                                    uploadResponse.name +
                                    '" ><input type="hidden" name="types[]" value="' +
                                    uploadResponse.type + '" >')
                            }
                        }
                    })
            }
        };

        $('#screen_id').change(function() {
            if ($("input[name=screen_id]").length) {
                $("input[name=screen_id]").remove();
            }
            list.append('<input type="hidden" name="screen_id" value="' + this.value + '" >')
            err = 0
        })

        $('#lang').change(function() {
            if ($("input[name=lang]").length) {
                $("input[name=lang]").remove();
            }
            list.append('<input type="hidden" name="lang" value="' + this.value + '" >')
            err = 0
        })
    </script>
@endsection
