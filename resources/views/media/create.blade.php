@extends('layouts.app-new')

@section('title', 'Add Wall Media')
@section('scripts')
    <script src="{{ asset('assets/js/plugins/uploaders/dropzone.min.js') }}"></script>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Add Wall Media</h5>
                </div>

                <div class="card-body">

                    <form action="{{ route('wallmedia.store') }}" method="post" id="mediaForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Room *</label>
                                    <select id="room_id" name="room_id" class="form-control" required>
                                        <option value="">Select Room</option>
                                        @foreach ($rooms as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Title (English) *</label>
                                    <input type="text" name="title_en" id="title_en" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Title (Arabic) *</label>
                                    <input type="text" name="title_ar" id="title_ar" class="form-control" required>
                                </div>
                            </div>
                            <ul id="file-upload-list" class="list-unstyled">
                            </ul>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary add_media">Add <i
                                    class="icon-plus-circle2 ml-2"></i></button>
                        </div>
                    </form>
                    <div class="form-group">
                        <label>Upload Media:</label>
                        {{-- <input type="file" name="media" class="file-input-ajax" accept="video/*" multiple="multiple" data-fouc> --}}
                        <form action="{{ route('upload_wallmedia') }}" class="dropzone" id="dropzone_multiple">
                        </form>

                        <ul id="file-upload-list2" class="list-unstyled">
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_script')
    <script>
        var list = $('#file-upload-list');
        var list2 = $('#file-upload-list2');
        // Multiple files
        Dropzone.options.dropzoneMultiple = {
            paramName: "media", // The name that will be used to transfer the file
            dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
            maxFilesize: 10000000000000, // MB
            addRemoveLinks: true,
            chunking: true,
            chunkSize: 10000000,
            // If true, the individual chunks of a file are being uploaded simultaneously.
            parallelChunkUploads: true,
            acceptedFiles: 'video/*',
            init: function() {
                this.on('addedfile', function() {
                        list2.append('<li>Uploading</li>')
                    }),
                    this.on('sending', function(file, xhr, formData) {
                        formData.append("_token", csrf_token);

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
                                    '" ><input type="hidden" name="durations[]" value="' +
                                    uploadResponse.duration + '" >')
                            }
                        }
                    })
            }
        };
    </script>
@endsection
