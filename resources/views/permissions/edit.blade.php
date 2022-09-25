@extends('layout.app')

@section('title')
    Edit Permission
@endsection

@section('header_scripts')
    <script src="{{ asset('assets/global_assets/js/plugins/forms/inputs/duallistbox/duallistbox.min.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/demo_pages/form_dual_listboxes.js') }}"></script>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Edit Permission</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('permissions.update', $permission->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Name:</label>
                            <input type="text" class="form-control" placeholder="admin" value="{{ $permission->name }}"
                                name="name" required>
                        </div>
                    </div>
                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            <label>Guard:</label>
                            <input type="text" class="form-control" placeholder="web" name="guard_name">
                        </div>
                    </div> --}}
                </div>

                <div class="form-group">
                    <label>Roles:</label>
                    <select multiple="multiple" class="form-control listbox" name="roles[]" data-fouc>
                        @foreach ($roles as $item)
                            <option value="{{ $item->id }}" @if (in_array($item->id, $roles_permission)) selected @endif>
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Update <i class="icon-add ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection
