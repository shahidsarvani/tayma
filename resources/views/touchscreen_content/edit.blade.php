@extends('layout.app')

@section('title')
    Add Touchtable Content
@endsection

@section('header_scripts')
    <script src="{{ asset('assets/global_assets/js/plugins/editors/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/demo_pages/editor_ckeditor_material.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/plugins/uploaders/dropzone.min.js') }}"></script>
    <style>
        #content-layout {
            display: none;
        }

        .col label {
            overflow: hidden;
            position: relative;
        }

        .imgbgchk:checked + label > .tick_container {
            opacity: 1;
        }

        /*         aNIMATION */
        .imgbgchk:checked + label > img {
            transform: scale(1.25);
            opacity: 0.3;
        }

        .tick_container {
            transition: .5s ease;
            opacity: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            cursor: pointer;
            text-align: center;
        }

        .tick {
            background-color: #292c42;
            color: white;
            font-size: 16px;
            padding: 6px 12px;
            height: 40px;
            width: 40px;
            border-radius: 100%;
        }

        .level-3-menu {
            display: none;
        }


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
        .image-area- {
            width: 100px;
        }
    </style>
@endsection


@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Add Touchtable Content</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('touchtable.content.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Menu:</label>
                            <select name="menu_id" class="form-control">
                                <option value="">Select Menu</option>
                                @foreach ($menus as $item)
                                    <option @if($item['id'] === $content->menu_id) selected @endif value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Language</label>
                            <select id="lang" class="form-control" name="lang" required>
                                <option value="">Select Language</option>
                                <option @if('ar' === $content->lang) selected @endif value="ar">Arabic</option>
                                <option @if('en' === $content->lang) selected @endif value="en">English</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Content:</label>
                            <textarea name="content" id="editor-full1" rows="4" cols="4" required>{{$content->content}}</textarea>
                            @error('content')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <ul id="file-upload-list2" class="list-unstyled">
                    </ul>
                    @if ($media)
                        @foreach ($media as $item)
                            <div class="col-md-3 my-2">
                                @if ($item->type == 'image')
                                    <div class="image-area-">
                                        <img src="{{ asset('storage/app/public/media/' . $item->name) }}" alt="Content"
                                             class="w-100">
                                        <a class="remove-image" href="{{ '/video-wall-screen/gallery/' . $item->id }}"
                                           style="display: inline;">&#215;</a>
                                    </div>

                                @else
                                    <div class="image-area-">
                                        <video src="{{ asset('storage/app/public/media/' . $item->name) }}" controls
                                               autoplay muted></video>
                                        <a class="remove-image" href="{{ '/video-wall-screen/gallery/' . $item->id }}"
                                           style="display: inline;">&#215;</a>
                                    </div>

                                @endif
                            </div>
                        @endforeach
                    @endif

                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Update <i class="icon-add ml-2"></i></button>
                </div>
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
