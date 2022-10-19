@extends('layout.app')

@section('title')
    Add Menu
@endsection
@section('header_scripts')
    <script src="{{ asset('assets/global_assets/js/plugins/uploaders/dropzone.min.js') }}"></script>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Touchtable Add Menu</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('touchtable.menus.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name (English):</label>
                            <input type="text" class="form-control" name="name_en" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name (Arabic):</label>
                            <input type="text" class="form-control" name="name_ar" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Parent Menu:</label>
                            <select name="menu_id" class="form-control">
                                <option value="">Select Parent Menu</option>
                                @foreach ($menus as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
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
                                    <option value="{{ $item->id }}">{{ $item->name_en }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Type:</label>
                            <select name="type" class="form-control" onchange="menuTypeChanged(this)" required>
                                <option value="">Select Menu Type</option>
                                <option value="main">Main</option>
                                <option value="side">Sidebar</option>
                                {{-- <option value="footer">Footer</option> --}}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Level:</label>
                            <input type="number" name="level" class="form-control" id="level" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status:</label>
                            <select name="is_active" class="form-control" required>
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Timeline Menu:</label>
                            <select name="is_timeline" class="form-control" required>
                                <option value="">Select Option</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Order:</label>
                            <input type="number" name="order" class="form-control" required>
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
                        <div class="hidden" id="image_partial">
                            @include('touchscreen_menus.image_partial')
                        </div>
                        <div class="hidden" id="icon_partial">
                            @include('touchscreen_menus.icon_partial')
                        </div>
                    </div>
                </div>
                <ul id="file-upload-list2" class="list-unstyled">
                </ul>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Add <i class="icon-add ml-2"></i></button>
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
            dictDefaultMessage: 'Drop Video for background <span>or CLICK</span>',
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
                                list2.append('<input type="hidden" name="file_names[]" value="' +
                                    uploadResponse.name +
                                    '" ><input type="hidden" name="types[]" value="' +
                                    uploadResponse.type + '" >')
                            }
                        }
                    })
            }
        };


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

        $(document).ready(function () {
            $('input[type="file"]').change(function (e) {
                var input = e.target;
                var imageName = input.files[0]?.name
                if (imageName !== "") {
                    $('.' + input.name + "_name").html(imageName)
                }
            });
        })
    </script>
@endsection
