<!-- Main navbar -->
<div class="navbar navbar-expand-lg navbar-dark bg-indigo navbar-static">
    <div class="d-flex flex-1 d-lg-none">
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>
    </div>

    <div class="navbar-brand text-center text-lg-left">
        <a href="{{ route('dashboard') }}" class="d-inline-block">
            @php
                $logo = App\Models\Setting::where('key', 'logo')->first();
            @endphp
            @if ($logo)
                <img src="{{ asset('storage/app/public/media/' . $logo->value) }}" class="d-sm-block" alt="">
            @else
                <h3 class="app-logo">{{ Str::upper(env('APP_NAME')) }}</h3>
            @endif
        </a>
    </div>

    <div class="navbar-collapse collapse flex-lg-1 mx-lg-3 order-2 order-lg-1" id="navbar-search">
    </div>

    <div class="d-flex justify-content-end align-items-center flex-1 flex-lg-0 order-1 order-lg-2">
        <ul class="navbar-nav flex-row">

            <li class="nav-item">
                <a href="{{ route('logout') }}" class="navbar-nav-link navbar-nav-link-toggler"
                    onclick="event.preventDefault(); document.getElementById('my-form').submit()">
                    <i class="icon-switch2"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->
