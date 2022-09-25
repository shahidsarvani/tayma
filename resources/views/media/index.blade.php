@extends('layout.app')

@section('title', 'Wall Media Gallery')
@section('scripts')
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
                    Wall Media Gallery
                </h6>
                {{-- <span class="text-muted d-block">Video grid with 4 - 2 - 1 columns</span> --}}
            </div>
            <div class="col-md-6">
                <a href="{{ route('media.create') }}" type="button" class="btn btn-primary float-right"><i
                        class="icon-plus3 mr-2"></i>Add Media</a>
            </div>
        </div>
    </div>

    <div class="row">
        @if ($media)
            @foreach ($media as $item)
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-img-actions m-1">
                            <div class="card-img embed-responsive embed-responsive-16by9">
                                <video src="{{ URL::asset('public/storage/media/' . $item->name) }}" muted
                                    controls></video>
                                <div class="video-content">
                                    <a href="{{ route('wallmedia.destroy', $item->id) }}"
                                        onclick="event.preventDefault(); $('.delete-form{{ $item->id }}').submit();"
                                        class="list-icons-item text-danger-600">
                                        <i class="icon-trash"></i>
                                    </a>
                                    <form action="{{ route('wallmedia.destroy', $item->id) }}" method="post"
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
        @else
            <h3>No record found</h3>
        @endif
        {{-- <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-img-actions m-1">
                    <div class="card-img embed-responsive embed-responsive-16by9">
                        <iframe allowfullscreen="" frameborder="0" mozallowfullscreen=""
                            src="https://player.vimeo.com/video/126945693?title=0&amp;byline=0&amp;portrait=0"
                            webkitallowfullscreen=""></iframe>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    <!-- /video grid -->
@endsection
