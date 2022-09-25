@extends('layout.app')

@section('title')
    Add CRUD Permissions
@endsection

@section('header_scripts')
    <script src="{{ asset('assets/global_assets/js/plugins/forms/inputs/duallistbox/duallistbox.min.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/demo_pages/form_dual_listboxes.js') }}"></script>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Add CRUD Permissions</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('permissions.crud_store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Name:</label>
                            <input type="text" class="form-control" placeholder="permission" name="name" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Roles:</label>
                    <select multiple="multiple" class="form-control listbox" name="roles[]" data-fouc>
                        @foreach ($roles as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Add <i class="icon-add ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection
