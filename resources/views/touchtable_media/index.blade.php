@extends('layout.app')

@section('title')
    Media Gallery
@endsection
@section('header_scripts')
    <script src="{{ asset('assets/global_assets/js/demo_pages/components_modals.js') }}"></script>
    <style>
        .card-img {
            position: relative;
        }

        .card-img .video-content {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
@endsection
@section('content')
    <!-- Video grid -->
    <div class="mb-3 pt-2">
        <div class="row">
            <div class="col-md-6">
                <h6 class="mb-0 font-weight-semibold">
                    Media Gallery
                </h6>
                {{-- <span class="text-muted d-block">Video grid with 4 - 2 - 1 columns</span> --}}
            </div>
            <div class="col-md-6">
                <a href="{{ route('touchtable.media.create') }}" type="button" class="btn btn-primary float-right"><i
                        class="icon-plus3 mr-2"></i>Add Media</a>
            </div>
        </div>
    </div>

    <div class="row">
        @if ($media_grouped)
            @foreach ($media_grouped as $key => $media)
                <div class="col-md-6">
                    @php
                        $screen = App\Models\Menu::find($key);
                        // dd($screen);
                    @endphp
                    <h3>{{ $screen->name_en }}</h3>
                    <div class="row">
                        @foreach ($media as $item)
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-img-actions m-1">
                                        @if ($item->type == 'image')
                                            <div class="card-img embed-responsive">
                                                <img src="{{ URL::asset('storage/app/public/media/' . $item->name) }}"
                                                    alt="" width="100%">
                                            @else
                                                <div class="card-img embed-responsive embed-responsive-16by9">
                                                    <video src="{{ URL::asset('storage/app/public/media/' . $item->name) }}"
                                                        muted controls></video>
                                        @endif
                                        <div class="video-content">
                                            <a data-toggle="modal" data-target="#modal{{ $item->id }}"
                                                class="list-icons-item text-danger-600"><i class="icon-pencil"></i></a>
                                            <a href="{{ route('touchtable.media.delete', $item->id) }}"
                                                onclick="event.preventDefault(); $('.delete-form{{ $item->id }}').submit();"
                                                class="list-icons-item text-danger-600">
                                                <i class="icon-trash"></i>
                                            </a>
                                            <form action="{{ route('touchtable.media.delete', $item->id) }}" method="post"
                                                class="d-none delete-form{{ $item->id }}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <!-- Basic modal -->
                    <div id="modal{{ $item->id }}" class="modal fade" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Gallery Item</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <form action="{{ route('touchtable.media.update', $item->id) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Sort Order</label>
                                            <input type="number" name="order" value="{{ $item->order }}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea name="description" cols="30" rows="2" class="form-control">{{ $item->description }}</textarea>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /basic modal -->
            @endforeach
    </div>
    </div>
    @endforeach
@else
    <h3>No record found</h3>
    @endif
    </div>
@endsection
