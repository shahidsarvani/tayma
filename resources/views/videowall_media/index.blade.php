@extends('layout.app')

@section('title')
    Media Gallery
@endsection
@section('header_scripts')
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
                <a href="{{ route('videowall.media.create') }}" type="button" class="btn btn-primary float-right"><i
                        class="icon-plus3 mr-2"></i>Add Media</a>
            </div>
        </div>
    </div>

    <div class="row">
        @if ($media_grouped)
            @foreach ($media_grouped as $key => $media)
                <div class="col-md-12">
                    @php
                        $screen = App\Models\Screen::whereSlug($key)->first();
                        // dd($screen);
                    @endphp
                    <h3>{{ $screen->name_en }}</h3>
                    <div class="row">
                        @foreach ($media as $item)
                            <div class="col-sm-4">
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
                                            <a href="{{ route('media.delete', $item->id) }}"
                                                onclick="event.preventDefault(); $('.delete-form{{ $item->id }}').submit();"
                                                class="list-icons-item text-danger-600">
                                                <i class="icon-trash"></i>
                                            </a>
                                            <form action="{{ route('media.delete', $item->id) }}" method="post"
                                                class="d-none delete-form{{ $item->id }}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
            @endforeach
    </div>
    </div>
    @endforeach
@else
    <h3>No record found</h3>
    @endif
    </div>
@endsection
