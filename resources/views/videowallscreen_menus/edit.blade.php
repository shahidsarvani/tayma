@extends('layout.app')

@section('title')
    Edit Video Wall Menu
@endsection

@section('header_scripts')
    <script src="{{ asset('assets/global_assets/js/plugins/uploaders/dropzone.min.js') }}"></script>

    <style>
        .image-area_ {
            width: 100px;
            height: 100px;
        }
        .image-area {
            position: absolute;
            width: 100px;
        }

        .image-area img {
            max-width: 100%;
            height: auto;
        }

        .remove-image {
            display: none;
            position: absolute;
            top: -10px;
            right: -10px;
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
            right: -11px;
        }

        .remove-image:active {
            background: #e54e4e;
            top: -10px;
            right: -11px;
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
        .image-area- img, .image-area- video, .image-area- {
            /*width: 100px;*/
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Edit Video Wall Menu</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('videowall.menus.update', $menu->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name (English):</label>
                            <input type="text" class="form-control" name="name_en" value="{{$menu->name_en}}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name (Arabic):</label>
                            <input type="text" class="form-control" name="name_ar" value="{{$menu->name_ar}}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Screen:</label>
                            <select name="screen_id" class="form-control">
                                <option value="">Select Screen</option>
                                @foreach ($screens as $item)
                                    <option value="{{ $item->id }}" @if($menu->screen_id === $item->id) selected @endif>{{ $item->name_en }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Parent Menu:</label>
                            <select name="menu_id" class="form-control">
                                <option value="">Select Parent Menu</option>
                                @foreach ($menus as $item)
                                    <option value="{{ $item['id'] }}" @if($menu->menu_id === $item['id']) selected @endif>{{ $item['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Type:</label>
                            <select name="type" class="form-control" onchange="menuTypeChanged(this)" required>
                                <option value="">Select Menu Type</option>
                                <option value="main" @if($menu->type === 'main') selected @endif>Main</option>
                                <option value="side" @if($menu->type === 'side') selected @endif>Sidebar</option>
                                {{-- <option value="footer" @if($menu->type === 'footer') selected @endif>Footer</option> --}}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Level:</label>
                            <input type="number" name="level" class="form-control" id="level" value="{{$menu->level}}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status:</label>
                            <select name="is_active" class="form-control" required>
                                <option value="">Select Status</option>
                                <option value="1" @if($menu->is_active) selected @endif>Active</option>
                                <option value="0" @if(!$menu->is_active) selected @endif>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Order:</label>
                            <input type="number" name="order" class="form-control" value="{{$menu->order}}"required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Background Image:</label>
                            <input type="file" name="bg_image" class="form-control">
                        </div>
                    </div>
                        <div class="col-md-6">
                            <div class="image-area_">
                                <div class="image-area">
                                    @if($menu->bg_image != null)
                                    <img src="{{asset('/storage/app/public/media/' . $menu->bg_image)}}">
                                    <a class="remove-image" href="{{ '/video-wall-screen/menu/bg/remove/' . $menu->id }}"
                                       style="display: inline;">&#215;</a>
                                    @endif
                                </div>
                            </div>
                        </div>
{{--                    <div class="col-md-6">--}}
{{--                        <div class="form-group">--}}
{{--                            <label>Introductory Video:</label>--}}
{{--                            <input type="file" name="intro_video" class="form-control" accept="video/mp4,video/x-m4v,video/*">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <div class="image-area_">--}}
{{--                            <div class="image-area">--}}
{{--                                @if($menu->intro_video != null)--}}
{{--                                <video style="width: 100px;'" src="{{ URL::asset('public/storage/media/' . $menu->intro_video) }}" muted controls></video>--}}
{{--                                <a class="remove-image" href="{{ '/video-wall-screen/menu/intro/video/remove/' . $menu->id . '/intro_video' }}"--}}
{{--                                   style="display: inline;">&#215;</a>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    <div class="col-md-6">--}}
{{--                        <div class="form-group">--}}
{{--                            <label>Introductory Video:</label>--}}
{{--                            <input type="file" name="intro_video_ar" class="form-control" accept="video/mp4,video/x-m4v,video/*">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <div class="image-area_">--}}
{{--                                <div class="image-area">--}}
{{--                                    @if($menu->intro_video_ar != null)--}}
{{--                                    <video style="width: 100px;'" src="{{ URL::asset('public/storage/media/' . $menu->intro_video_ar) }}" muted controls></video>--}}
{{--                                    <a class="remove-image" href="{{ '/video-wall-screen/menu/intro/video/remove/' . $menu->id . '/intro_video_ar' }}"--}}
{{--                                       style="display: inline;">&#215;</a>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    <div class="col-md-12">
                        <div class="hidden {{ (($menu->image_en && $menu->image_en != '') || ($menu->image_ar && $menu->image_ar != '')) ? 'show' : '' }}" id="image_partial">
                            @include('videowallscreen_menus.image_partial')
                        </div>
                        <div class="hidden {{ (($menu->icon_en && $menu->icon_en != '') || ($menu->icon_ar && $menu->icon_ar != '')) ? 'show' : '' }}" id="icon_partial">
                            @include('videowallscreen_menus.icon_partial')
                        </div>
                    </div>
                    @if ($media)
                        @foreach ($media as $item)
                            <div class="col-md-3 my-2">
                                @if ($item->type == 'image')
                                    <div class="image-area-">
                                        <img src="{{ asset('storage/app/public/media/' . $item->name) }}" alt="Content"
                                             class="w-100">
                                        <a class="remove-image" href="{{ env('APP_URL') . '/video-wall-screen/gallery/' . $item->id }}"
                                           style="display: inline;">&#215;</a>
                                    </div>

                                @else
                                    <div class="image-area-">
                                        <video src="{{ asset('storage/app/public/media/' . $item->name) }}" controls
                                               autoplay muted></video>
                                        <a class="remove-image" href="{{ env('APP_URL') . '/video-wall-screen/gallery/' . $item->id }}"
                                           style="display: inline;">&#215;</a>
                                    </div>

                                @endif
                            </div>
                        @endforeach
                    @endif
                    @if ($media_ar)
                        @foreach ($media_ar as $item)
                            <div class="col-md-3 my-2">
                                @if ($item->type == 'image')
                                    <div class="image-area-">
                                        <img src="{{ asset('storage/app/public/media/' . $item->name) }}" alt="Content"
                                             class="w-100">
                                        <a class="remove-image" href="{{ env('APP_URL') . '/video-wall-screen/gallery/' . $item->id }}"
                                           style="display: inline;">&#215;</a>
                                    </div>

                                @else
                                    <div class="image-area-">
                                        <video src="{{ asset('storage/app/public/media/' . $item->name) }}" controls
                                               autoplay muted></video>
                                        <a class="remove-image" href="{{ env('APP_URL') . '/video-wall-screen/gallery/' . $item->id }}"
                                           style="display: inline;">&#215;</a>
                                    </div>

                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>

                <ul id="file-upload-list2" class="list-unstyled"></ul>
                <ul id="file-upload-list2-ar" class="list-unstyled"></ul>
                <ul id="file-upload-list2-bg" class="list-unstyled"></ul>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Update <i class="icon-add ml-2"></i></button>
                </div>
            </form>
        </div>
        <form action="{{ route('videowall.media.upload') }}" class="dropzone mt-3" id="dropzone_multiple"></form>
        <form action="{{ route('videowall.media.upload') }}" class="dropzone mt-3" id="dropzone_multiple_ar"></form>
        <form action="{{ route('videowall.media.upload') }}" class="dropzone mt-3" id="dropzone_multiple_bg"></form>

        <ul id="file-upload-list" class="list-unstyled"></ul>
        <ul id="file-upload-list-ar" class="list-unstyled"></ul>
        <ul id="file-upload-list-bg" class="list-unstyled"></ul>

    </div>
@endsection

@section('footer_scripts')
    <script>
        const level = document.getElementById('level')
        const imagePartial = document.getElementById('image_partial')
        const iconPartial = document.getElementById('icon_partial')

        function menuTypeChanged(event) {
            console.log(event)
            if (event.value === 'main') {
                level.value = '0'
                level.setAttribute('readonly', 'true');
                imagePartial.classList.add('show')
                iconPartial.classList.remove('show')
            } else if (event.value === 'side') {
                level.value = '1'
                level.removeAttribute('readonly');
                level.setAttribute('min', '1');
                imagePartial.classList.remove('show')
                iconPartial.classList.remove('show')
            } else {
                level.value = '1'
                level.setAttribute('readonly', 'true');
                imagePartial.classList.remove('show')
                iconPartial.classList.add('show')
            }
        }
        $(document).ready(function() {
            $('input[type="file"]').change(function(e) {
                var input = e.target;
                var imageName = input.files[0]?.name
                if (imageName !== "") {
                    $('.' + input.name + "_name").html(imageName)
                }
            });
        })


        var list = $('#file-upload-list');
        var list2 = $('#file-upload-list2');
        let listScreenMenu = '';
        console.log(list)
        // Multiple files
        Dropzone.options.dropzoneMultiple = {
            paramName: "media", // The name that will be used to transfer the file
            dictDefaultMessage: 'Introductory Video <h1> English</h1>',
            maxFilesize: 1024, // MB
            addRemoveLinks: true,
            chunking: true,
            chunkSize: 2000000,
            // If true, the individual chunks of a file are being uploaded simultaneously.
            parallelChunkUploads: true,
            acceptedFiles: 'video/*',
            init: function () {
                this.on('addedfile', function () {
                    list.append('<li>Uploading</li>')
                }),
                    this.on('sending', function (file, xhr, formData) {
                        formData.append("_token", "{{ csrf_token() }}");

                        // This will track all request so we can get the correct request that returns final response:
                        // We will change the load callback but we need to ensure that we will call original
                        // load callback from dropzone
                        var dropzoneOnLoad = xhr.onload;
                        xhr.onload = function (e) {
                            dropzoneOnLoad(e)
                            // Check for final chunk and get the response
                            var uploadResponse = JSON.parse(xhr.responseText)
                            if (typeof uploadResponse.name === 'string') {
                                list.append('<li>Uploaded: ' + uploadResponse.path + uploadResponse.name +
                                    '</li>')
                                list2.append('<input type="hidden" name="intro_video[]" value="' +
                                    uploadResponse.name +
                                    '" ><input type="hidden" name="types[]" value="' +
                                    uploadResponse.type + '" >')
                            }
                        }
                    })
            }
        };

        var list_ar = $('#file-upload-list-ar');

        var list2_ar = $('#file-upload-list2-ar');

        Dropzone.options.dropzoneMultipleAr = {
            paramName: "media", // The name that will be used to transfer the file
            dictDefaultMessage: 'Introductory Video <h1>Arabic </h1>',
            maxFilesize: 1024, // MB
            addRemoveLinks: true,
            chunking: true,
            chunkSize: 2000000,
            // If true, the individual chunks of a file are being uploaded simultaneously.
            parallelChunkUploads: true,
            acceptedFiles: 'video/*',
            init: function () {
                this.on('addedfile', function () {
                    list_ar.append('<li>Uploading</li>')
                }),
                    this.on('sending', function (file, xhr, formData) {
                        formData.append("_token", "{{ csrf_token() }}");

                        // This will track all request so we can get the correct request that returns final response:
                        // We will change the load callback but we need to ensure that we will call original
                        // load callback from dropzone
                        var dropzoneOnLoad = xhr.onload;
                        xhr.onload = function (e) {
                            dropzoneOnLoad(e)
                            // Check for final chunk and get the response
                            var uploadResponse = JSON.parse(xhr.responseText)
                            if (typeof uploadResponse.name === 'string') {
                                list_ar.append('<li>Uploaded: ' + uploadResponse.path + uploadResponse.name +
                                    '</li>')
                                list2_ar.append('<input type="hidden" name="intro_video_ar[]" value="' +
                                    uploadResponse.name +
                                    '" ><input type="hidden" name="types_ar[]" value="' +
                                    uploadResponse.type + '" >')
                            }
                        }
                    })
            }
        };
        var list_bg = $('#file-upload-list-bg');
        var list2_bg = $('#file-upload-list2-bg');

        Dropzone.options.dropzoneMultipleBg = {
            paramName: "media", // The name that will be used to transfer the file
            dictDefaultMessage: 'Background <h1> Video </h1>',
            maxFilesize: 1024, // MB
            addRemoveLinks: true,
            chunking: true,
            chunkSize: 2000000,
            // If true, the individual chunks of a file are being uploaded simultaneously.
            parallelChunkUploads: true,
            acceptedFiles: 'video/*',
            init: function () {
                this.on('addedfile', function () {
                    list_bg.append('<li>Uploading</li>')
                }),
                    this.on('sending', function (file, xhr, formData) {
                        formData.append("_token", "{{ csrf_token() }}");

                        // This will track all request so we can get the correct request that returns final response:
                        // We will change the load callback but we need to ensure that we will call original
                        // load callback from dropzone
                        var dropzoneOnLoad = xhr.onload;
                        xhr.onload = function (e) {
                            dropzoneOnLoad(e)
                            // Check for final chunk and get the response
                            var uploadResponse = JSON.parse(xhr.responseText)
                            if (typeof uploadResponse.name === 'string') {
                                list_bg.append('<li>Uploaded: ' + uploadResponse.path + uploadResponse.name +
                                    '</li>')
                                list2_bg.append('<input type="hidden" name="bg_video[]" value="' +
                                    uploadResponse.name +
                                    '" ><input type="hidden" name="types_bg[]" value="' +
                                    uploadResponse.type + '" >')
                            }
                        }
                    })
            }
        };
    </script>
@endsection
