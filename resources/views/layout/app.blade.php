@include('layout.header_scripts')


<body>

    @include('layout.logout-form')

    @include('layout.header')


    <!-- Page content -->
    <div class="page-content">

        @include('layout.sidebar')


        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Inner content -->
            <div class="content-inner">

                {{-- @include('layout.breadcrumb') --}}


                <!-- Content area -->
                <div class="content">
                    @include('alert')
                    @yield('content')
                </div>
                <!-- /content area -->

                @include('layout.footer')

            </div>
            <!-- /inner content -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

    @yield('footer_scripts')
</body>

</html>
