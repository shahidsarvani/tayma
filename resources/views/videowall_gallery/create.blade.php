@extends('layout.app')

@section('title', 'Add Touchtable Media')
@section('header_scripts')
    <script src="{{ asset('assets/global_assets/js/plugins/uploaders/dropzone.min.js') }}"></script>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Add Touchtable Media</h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Language *</label>
                                <select id="lang" class="form-control" required>
                                    <option value="">Select Language</option>
                                    <option value="ar">Arabic</option>
                                    <option value="en">English</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Screen *</label>
                                <select id="screen_id" class="form-control" required>
                                    <option value="">Select Screen *</option>
                                    @foreach ($screens as $item)
                                        <option value="{{ $item->id }}">{{ $item->name_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Menu *</label>
                                <select id="menu_id" class="form-control" required>
                                    <option value="">Select Menu *</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Upload Media:</label>
                        {{-- <input type="file" name="media" class="file-input-ajax" accept="video/*" multiple="multiple" data-fouc> --}}
                        <form action="{{ route('videowall.media.upload') }}" class="dropzone" id="dropzone_multiple">
                        </form>

                        <form action="{{ route('videowall.gallery.store') }}" method="post" id="mediaForm">
                            @csrf
                            <ul id="file-upload-list" class="list-unstyled">
                            </ul>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary add_media">Add <i
                                class="icon-plus-circle2 ml-2"></i></button>
                        </form>
                    </div>
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
            if (!$('input[name=menu_id]').length) {
                err = 1;
            }
            if (!err) {
                form.submit();
            } else {
                alert('Please complete required fields')
            }
        })
        var list = $('#file-upload-list');
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
            getScreenMenus(this.value)
            if ($("input[name=screen_id]").length) {
                $("input[name=screen_id]").remove();
            }
            list.append('<input type="hidden" name="screen_id" value="' + this.value + '" >')
            err = 0
        })
        $('#menu_id').change(function() {
            if ($("input[name=menu_id]").length) {
                $("input[name=menu_id]").remove();
            }
            list.append('<input type="hidden" name="menu_id" value="' + this.value + '" >')
            err = 0
        })

        $('#lang').change(function() {
            if ($("input[name=lang]").length) {
                $("input[name=lang]").remove();
            }
            list.append('<input type="hidden" name="lang" value="' + this.value + '" >')
            err = 0
        })

        function getScreenMenus(screen_id) {
            screen_id = screen_id | 0
            var url = "../getscreenmainmenu/" + screen_id
            console.log(url)
            $.ajax({
                url: url,
                method: 'get',
                dataType: 'json',
                success: function(response) {
                    var html_text = '<option value="">Select Menu *</option>'
                    if (response.length) {
                        for (var i = 0; i < response.length; i++) {
                            html_text += '<option value="' + response[i].id + '">' + response[i].name_en +
                                '</option>'
                        }
                    }
                    $('#menu_id').empty().append(html_text);
                }
            })
        }
    </script>
@endsection
