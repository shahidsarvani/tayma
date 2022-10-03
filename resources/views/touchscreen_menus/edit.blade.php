@extends('layout.app')

@section('title')
    Edit Menu
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
                    <div class="col-md-4">
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
                    <div class="col-md-4">
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Level:</label>
                            <input type="number" name="level" class="form-control" id="level" value="{{$menu->level}}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status:</label>
                            <select name="is_active" class="form-control" required>
                                <option value="">Select Status</option>
                                <option value="1" @if($menu->is_active) selected @endif>Active</option>
                                <option value="0" @if(!$menu->is_active) selected @endif>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Timeline Menu:</label>
                            <select name="is_timeline" class="form-control" required>
                                <option value="">Select Option</option>
                                <option value="1" @if($menu->is_timeline) selected @endif>Yes</option>
                                <option value="0" @if(!$menu->is_timeline) selected @endif>no</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Order:</label>
                            <input type="number" name="order" class="form-control" value="{{$menu->order}}"required>
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
                </div>
                
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Update <i class="icon-add ml-2"></i></button>
                </div>
            </form>
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
    </script>
@endsection