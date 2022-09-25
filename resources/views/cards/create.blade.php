@extends('layout.app')

@section('title')
    Add RFID Card
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Add RFID Card</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('cards.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Card Token:</label>
                            <input type="text" class="form-control @error('card_id') is-invalid @enderror" name="card_id" required>
                            @error('card_id')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Screen:</label>
                            <select name="screen_id" class="form-control @error('screen_id') is-invalid @enderror" required>
                                <option value="">Select Screen</option>
                                @foreach ($screens as $screen)
                                    <option value="{{ $screen->id }}">{{ $screen->name_en }}</option>
                                @endforeach
                            </select>
                            @error('screen_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status:</label>
                            <select name="is_active" class="form-control @error('is_active') is-invalid @enderror" required>
                                <option value="">Select Option</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @error('is_active')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Add <i class="icon-add ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection
