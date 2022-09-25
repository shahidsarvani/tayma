<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-12 text-center m-auto">
        @if (Session::has('success'))
            <div class="alert alert-success border-0 alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                {{ session('success') }}
            </div>
        @elseif(Session::has('warning'))
            <div class="alert alert-warning border-0 alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                {{ session('warning') }}
            </div>
        @elseif(Session::has('error'))
            <div class="alert alert-danger border-0 alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                {{ session('error') }}
            </div>
        @elseif(Session::has('deleted'))
            <div class="alert alert-secondary border-0 alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                {{ session('deleted') }}
            </div>
        @endif
    </div>
</div>
