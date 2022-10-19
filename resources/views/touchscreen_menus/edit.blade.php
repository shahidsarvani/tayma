@extends('layout.app')

@section('title')
    Edit Menu
@endsection
@section('header_scripts')
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
        .image-area- img, .image-area- video, .image-area- {
            width: 100px;
        }
    </style>

@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Edit Menu</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('touchtable.menus.update', $menu->id) }}" method="post" enctype="multipart/form-data">
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
                            <label>Screen:</label>
                            <select name="screen_id" class="form-control">
                                <option value="">Select Screen</option>
                                @foreach ($screens as $item)
                                    <option @if($menu->screen_id == $item->id) selected @endif value="{{ $item->id }}">{{ $item->name_en }}</option>
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
                            <label>Timeline Menu:</label>
                            <select name="is_timeline" class="form-control" required>
                                <option value="">Select Option</option>
                                <option value="1" @if($menu->is_timeline) selected @endif>Yes</option>
                                <option value="0" @if(!$menu->is_timeline) selected @endif>no</option>
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
                            <label>Background Image</label>
                            <label class="custom-file" for="bg_image">
                                <input id="bg_image" type="file" class="custom-file-input" name="bg_image" accept="image/*">
                                <span class="custom-file-label">Choose background Image</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="hidden {{ (($menu->image_en && $menu->image_en != '') || ($menu->image_ar && $menu->image_ar != '')) ? 'show' : '' }}" id="image_partial">
                            @include('touchscreen_menus.image_partial')
                        </div>
                        <div class="hidden {{ (($menu->icon_en && $menu->icon_en != '') || ($menu->icon_ar && $menu->icon_ar != '')) ? 'show' : '' }}" id="icon_partial">
                            @include('touchscreen_menus.icon_partial')
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
                                        <a class="remove-image" href="{{ env('APP_URL') . '/video-wall-screen/gallery/' . $item->id }}"
                                           style="display: inline;">&#215;</a>
                                    </div>

                                @else
                                    <div class="image-area-">
                                        <video src="{{ asset('storage/app/public/media/' . $item->name) }}" controls
                                               autoplay muted></video>
                                        <a class="remove-image" href="{{  env('APP_URL') . '/video-wall-screen/gallery/' . $item->id }}"
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
        console.log(list)
        // Multiple files
        Dropzone.options.dropzoneMultiple = {
            paramName: "media", // The name that will be used to transfer the file
            dictDefaultMessage: 'Drop Video for background <span>or CLICK</span>',
            maxFilesize: 1024, // MB
            addRemoveLinks: true,
            chunking: true,
            chunkSize: 2000000,
            // If true, the individual chunks of a file are being uploaded simultaneously.
            parallelChunkUploads: true,
            acceptedFiles: 'video/*',
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
