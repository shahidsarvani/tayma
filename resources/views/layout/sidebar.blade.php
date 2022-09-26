<!-- Main sidebar -->
<div class="sidebar sidebar-light sidebar-main sidebar-expand-lg">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-section">
            <div {{-- class="sidebar-user-material" --}} style="background-color: #292c42">
                <div class="sidebar-section-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            {{-- <button type="button" class="btn btn-outline-light border-transparent btn-icon btn-sm rounded-pill">
										<i class="icon-wrench"></i>
									</button> --}}
                        </div>
                        <a href="#" class="flex-1 text-center"><img
                                src="{{ asset('assets/global_assets/images/placeholders/placeholder.jpg') }}"
                                class="img-fluid rounded-circle shadow-sm" width="80" height="80"
                                alt=""></a>
                        <div class="flex-1 text-right">
                            <button type="button"
                                class="btn btn-outline-light border-transparent btn-icon rounded-pill btn-sm sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                                <i class="icon-transmission"></i>
                            </button>

                            <button type="button"
                                class="btn btn-outline-light border-transparent btn-icon rounded-pill btn-sm sidebar-mobile-main-toggle d-lg-none">
                                <i class="icon-cross2"></i>
                            </button>
                        </div>
                    </div>

                    <div class="text-center">
                        <h6 class="mb-0 text-white text-shadow-dark mt-3">{{ auth()->user()->name }}</h6>
                        <span
                            class="font-size-sm text-white text-shadow-dark">{{ ucfirst(auth()->user()->roles->isNotEmpty() ? auth()->user()->roles[0]->name: '') }}</span>
                    </div>
                </div>

                <div class="sidebar-user-material-footer">
                    <a href="#user-nav"
                        class="d-flex justify-content-between align-items-center text-shadow-dark dropdown-toggle"
                        data-toggle="collapse"><span>My account</span></a>
                </div>
            </div>

            <div class="collapse border-bottom" id="user-nav">
                <ul class="nav nav-sidebar">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="icon-user-plus"></i>
                            <span>My profile</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link"
                            onclick="event.preventDefault(); document.getElementById('my-form').submit()">
                            <i class="icon-switch2"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /user menu -->


        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link @if (Route::is('dashboard')) active @endif">
                        <i class="icon-home4"></i>
                        <span>
                            Dashboard
                        </span>
                    </a>
                </li>

                @can('touchtable-screen')
                    <li class="nav-item-header">
                        <div class="text-uppercase font-size-xs line-height-xs mt-1">Touchtable Screen</div> <i
                            class="icon-menu" title="Touchtable Screen"></i>
                    </li>
                    @can(['add-touchtable-screen-menu', 'edit-touchtable-screen-menu', 'delete-touchtable-screen-menu',
                        'view-touchtable-screen-menu'])
                        <li class="nav-item nav-item-submenu @if (Route::is('touchtable.menus.*')) nav-item-open @endif">
                            <a href="#" class="nav-link"><i class="icon-menu3"></i> <span>Menu</span></a>
                            <ul class="nav nav-group-sub" data-submenu-title="Menu"
                                @if (Route::is('touchtable.menus.*')) style="display: block" @endif>
                                @can('add-touchtable-screen-menu')
                                    <li class="nav-item"><a href="{{ route('touchtable.menus.create') }}"
                                            class="nav-link @if (Route::is('touchtable.menus.create')) active @endif">Add Menu</a></li>
                                @endcan
                                @can(['edit-touchtable-screen-menu', 'delete-touchtable-screen-menu',
                                    'view-touchtable-screen-menu'])
                                    <li class="nav-item"><a href="{{ route('touchtable.menus.index') }}"
                                            class="nav-link @if (Route::is(['touchtable.menus.index', 'touchtable.menus.edit'])) active @endif">Menu List</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can(['add-touchtable-screen-media', 'edit-touchtable-screen-media', 'delete-touchtable-screen-media',
                        'view-touchtable-screen-media'])
                        <li class="nav-item nav-item-submenu @if (Route::is('touchtable.media.*')) nav-item-open @endif">
                            <a href="#" class="nav-link"><i class="icon-camera"></i> <span>Gallery</span></a>
                            <ul class="nav nav-group-sub" data-submenu-title="Videos"
                                @if (Route::is('touchtable.media.*')) style="display: block" @endif>
                                @can('add-touchtable-screen-media')
                                    <li class="nav-item"><a href="{{ route('touchtable.media.create') }}"
                                            class="nav-link @if (Route::is('touchtable.media.create')) active @endif">Add Item(s)</a></li>
                                @endcan
                                @can(['edit-touchtable-screen-media', 'delete-touchtable-screen-media',
                                    'view-touchtable-screen-media'])
                                    <li class="nav-item"><a href="{{ route('touchtable.media.index') }}"
                                            class="nav-link @if (Route::is(['touchtable.media.index', 'touchtable.media.edit'])) active @endif">Gallery List</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can(['add-touchtable-screen-content', 'edit-touchtable-screen-content', 'delete-touchtable-screen-content',
                        'view-touchtable-screen-content'])
                        <li class="nav-item nav-item-submenu @if (Route::is('touchtable.content.*')) nav-item-open @endif">
                            <a href="#" class="nav-link"><i class="icon-camera"></i> <span>Content</span></a>
                            <ul class="nav nav-group-sub" data-submenu-title="Videos"
                                @if (Route::is('touchtable.content.*')) style="display: block" @endif>
                                @can('add-touchtable-screen-content')
                                    <li class="nav-item"><a href="{{ route('touchtable.content.create') }}"
                                            class="nav-link @if (Route::is('touchtable.content.create')) active @endif">Add Content</a></li>
                                @endcan
                                @can(['edit-touchtable-screen-content', 'delete-touchtable-screen-content',
                                    'view-touchtable-screen-content'])
                                    <li class="nav-item"><a href="{{ route('touchtable.content.index') }}"
                                            class="nav-link @if (Route::is(['touchtable.content.index', 'touchtable.content.edit'])) active @endif">Content</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                @endcan

                @can('portrait-screen')
                    <li class="nav-item-header">
                        <div class="text-uppercase font-size-xs line-height-xs mt-1">Portrait Screens</div> <i
                             class="icon-menu" title="Portrait Screens"></i>
                    </li>
                    @can(['add-portrait-screen', 'edit-portrait-screen', 'delete-portrait-screen', 'view-portrait-screen'])
                        <li class="nav-item nav-item-submenu @if (Route::is('portrait.screens.*')) nav-item-open @endif">
                            <a href="#" class="nav-link"><i class="icon-screen3"></i> <span>Screens</span></a>
                            <ul class="nav nav-group-sub" data-submenu-title="Screens"
                                @if (Route::is('portrait.screens.*')) style="display: block" @endif>
                                @can('add-portrait-screen')
                                    <li class="nav-item"><a href="{{ route('portrait.screens.create') }}"
                                            class="nav-link @if (Route::is('portrait.screens.create')) active @endif">Add Screen</a></li>
                                @endcan
                                @can(['edit-portrait-screen', 'delete-portrait-screen', 'view-portrait-screen'])
                                    <li class="nav-item"><a href="{{ route('portrait.screens.index') }}"
                                            class="nav-link @if (Route::is(['portrait.screens.index', 'portrait.screens.edit'])) active @endif">Screen List</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can(['add-portrait-screen-video', 'delete-portrait-screen-video', 'view-portrait-screen-video'])
                        <li class="nav-item nav-item-submenu @if (Route::is('portrait.media.*')) nav-item-open @endif">
                            <a href="#" class="nav-link"><i class="icon-film4"></i> <span>Media</span></a>
                            <ul class="nav nav-group-sub" data-submenu-title="Media"
                                @if (Route::is('portrait.media.*')) style="display: block" @endif>
                                @can('add-portrait-screen-video')
                                    <li class="nav-item"><a href="{{ route('portrait.media.create') }}"
                                            class="nav-link @if (Route::is('portrait.media.create')) active @endif">Add Media</a></li>
                                @endcan
                                @can(['delete-portrait-screen-video', 'view-portrait-screen-video'])
                                    <li class="nav-item"><a href="{{ route('portrait.media.index') }}"
                                            class="nav-link @if (Route::is('portrait.media.index')) active @endif">Media List</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                @endcan
                {{-- Video Wall Screens --}}
                @can('video-wall-screen')
                    <li class="nav-item-header">
                        <div class="text-uppercase font-size-xs line-height-xs mt-1">Video Wall Screens</div> <i
                            class="icon-menu" title="Video Wall Screens"></i>
                    </li>
                    @can(['add-video-wall-screen', 'edit-video-wall-screen', 'delete-video-wall-screen',
                        'view-video-wall-screen'])
                        <li class="nav-item nav-item-submenu @if (Route::is('videowall.screens.*')) nav-item-open @endif">
                            <a href="#" class="nav-link"><i class="icon-screen3"></i> <span>Screens</span></a>
                            <ul class="nav nav-group-sub" data-submenu-title="Screens"
                                @if (Route::is('videowall.screens.*')) style="display: block" @endif>
                                @can('add-video-wall-screen')
                                    <li class="nav-item"><a href="{{ route('videowall.screens.create') }}"
                                            class="nav-link @if (Route::is('videowall.screens.create')) active @endif">Add Screen</a></li>
                                @endcan
                                @can(['edit-video-wall-screen', 'delete-video-wall-screen', 'view-video-wall-screen'])
                                    <li class="nav-item"><a href="{{ route('videowall.screens.index') }}"
                                            class="nav-link @if (Route::is(['videowall.screens.index', 'videowall.screens.edit'])) active @endif">Screen List</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can(['add-video-wall-screen-video', 'delete-video-wall-screen-video', 'view-video-wall-screen-video'])
                        <li class="nav-item nav-item-submenu @if (Route::is('videowall.media.*')) nav-item-open @endif">
                            <a href="#" class="nav-link"><i class="icon-film4"></i> <span>Media</span></a>
                            <ul class="nav nav-group-sub" data-submenu-title="Media"
                                @if (Route::is('videowall.media.*')) style="display: block" @endif>
                                @can('add-video-wall-screen-video')
                                    <li class="nav-item"><a href="{{ route('videowall.media.create') }}"
                                            class="nav-link @if (Route::is('videowall.media.create')) active @endif">Add Media</a></li>
                                @endcan
                                @can(['delete-video-wall-screen-video', 'view-video-wall-screen-video'])
                                    <li class="nav-item"><a href="{{ route('videowall.media.index') }}"
                                            class="nav-link @if (Route::is('videowall.media.index')) active @endif">Media List</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can(['add-videowall-screen-menu', 'edit-videowall-screen-menu', 'delete-videowall-screen-menu',
                        'view-videowall-screen-menu'])
                        <li class="nav-item nav-item-submenu @if (Route::is('videowall.menus.*')) nav-item-open @endif">
                            <a href="#" class="nav-link"><i class="icon-menu3"></i> <span>Menu</span></a>
                            <ul class="nav nav-group-sub" data-submenu-title="Menu"
                                @if (Route::is('videowall.menus.*')) style="display: block" @endif>
                                @can('add-videowall-screen-menu')
                                    <li class="nav-item"><a href="{{ route('videowall.menus.create') }}"
                                            class="nav-link @if (Route::is('videowall.menus.create')) active @endif">Add Menu</a></li>
                                @endcan
                                @can(['edit-videowall-screen-menu', 'delete-videowall-screen-menu',
                                    'view-videowall-screen-menu'])
                                    <li class="nav-item"><a href="{{ route('videowall.menus.index') }}"
                                            class="nav-link @if (Route::is(['videowall.menus.index', 'videowall.menus.edit'])) active @endif">Menu List</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can(['add-videowall-gallery', 'edit-videowall-gallery', 'delete-videowall-gallery',
                        'view-videowall-gallery'])
                        <li class="nav-item nav-item-submenu @if (Route::is('videowall.gallery.*')) nav-item-open @endif">
                            <a href="#" class="nav-link"><i class="icon-camera"></i> <span>Gallery</span></a>
                            <ul class="nav nav-group-sub" data-submenu-title="Videos"
                                @if (Route::is('videowall.gallery.*')) style="display: block" @endif>
                                @can('add-videowall-gallery')
                                    <li class="nav-item"><a href="{{ route('videowall.gallery.create') }}"
                                            class="nav-link @if (Route::is('videowall.gallery.create')) active @endif">Add Item(s)</a></li>
                                @endcan
                                @can(['edit-videowall-gallery', 'delete-videowall-gallery',
                                    'view-videowall-gallery'])
                                    <li class="nav-item"><a href="{{ route('videowall.gallery.index') }}"
                                            class="nav-link @if (Route::is(['videowall.gallery.index', 'videowall.gallery.edit'])) active @endif">Gallery List</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can(['add-videowall-screen-content', 'edit-videowall-screen-content', 'delete-videowall-screen-content',
                        'view-videowall-screen-content'])
                        <li class="nav-item nav-item-submenu @if (Route::is('videowall.content.*')) nav-item-open @endif">
                            <a href="#" class="nav-link"><i class="icon-camera"></i> <span>Content</span></a>
                            <ul class="nav nav-group-sub" data-submenu-title="Videos"
                                @if (Route::is('videowall.content.*')) style="display: block" @endif>
                                @can('add-videowall-screen-content')
                                    <li class="nav-item"><a href="{{ route('videowall.content.create') }}"
                                            class="nav-link @if (Route::is('videowall.content.create')) active @endif">Add Content</a></li>
                                @endcan
                                @can(['edit-videowall-screen-content', 'delete-videowall-screen-content',
                                    'view-videowall-screen-content'])
                                    <li class="nav-item"><a href="{{ route('videowall.content.index') }}"
                                            class="nav-link @if (Route::is(['videowall.content.index', 'videowall.content.edit'])) active @endif">Content</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                @endcan
                {{-- /Video Wall Screens --}}
                <li class="nav-item-header">
                    <div class="text-uppercase font-size-xs line-height-xs mt-1">With RFID Screen</div> <i
                        class="icon-menu" title="With RFID Screen"></i>
                </li>
                @can(['add-screen', 'edit-screen', 'delete-screen', 'view-screen'])
                    <li class="nav-item nav-item-submenu @if (Route::is('screens.*')) nav-item-open @endif">
                        <a href="#" class="nav-link"><i class="icon-screen3"></i> <span>Screens</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Screens"
                            @if (Route::is('screens.*')) style="display: block" @endif>
                            @can('add-screen')
                                <li class="nav-item"><a href="{{ route('screens.create') }}"
                                        class="nav-link @if (Route::is('screens.create')) active @endif">Add Screen</a></li>
                            @endcan
                            @can(['edit-screen', 'delete-screen', 'view-screen'])
                                <li class="nav-item"><a href="{{ route('screens.index') }}"
                                        class="nav-link @if (Route::is(['screens.index', 'screens.edit'])) active @endif">Screen List</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                {{-- With RFID Screen Media --}}

                {{-- @can(['add-with-rfid-screen-screen-video', 'delete-with-rfid-screen-video', 'view-with-rfid-screen-video'])
                    <li class="nav-item nav-item-submenu @if (Route::is('withrfid.media.*')) nav-item-open @endif">
                        <a href="#" class="nav-link"><i class="icon-film4"></i> <span>Media</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Media"
                            @if (Route::is('with-rfid.media.*')) style="display: block" @endif>
                            @can('add-with-rfid-screen-video')
                                <li class="nav-item"><a href="{{ route('withrfid.media.create') }}"
                                                        class="nav-link @if (Route::is('withrfid.media.create')) active @endif">Add Media</a></li>
                            @endcan
                            @can(['delete-with-rfid-screen-video', 'view-with-rfid-screen-video'])
                                <li class="nav-item"><a href="{{ route('withrfid.media.index') }}"
                                                        class="nav-link @if (Route::is('withrfid.media.index')) active @endif">Media List</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan --}}
                {{-- /With RFID Screen Media --}}

                @can(['add-card', 'edit-card', 'delete-card', 'view-card'])
                    <li class="nav-item nav-item-submenu @if (Route::is('cards.*')) nav-item-open @endif">
                        <a href="#" class="nav-link"><i class="icon-credit-card2"></i> <span>RFID Cards</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Cards"
                            @if (Route::is('cards.*')) style="display: block" @endif>
                            @can('add-card')
                                <li class="nav-item"><a href="{{ route('cards.create') }}"
                                        class="nav-link @if (Route::is('cards.create')) active @endif">Add RFID Card</a>
                                </li>
                            @endcan
                            @can(['edit-card', 'delete-card', 'view-card'])
                                <li class="nav-item"><a href="{{ route('cards.index') }}"
                                        class="nav-link @if (Route::is(['cards.index', 'cards.edit'])) active @endif">RFID Card List</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can(['add-slide', 'edit-slide', 'delete-slide', 'view-slide'])
                    <li class="nav-item nav-item-submenu @if (Route::is('slides.*')) nav-item-open @endif">
                        <a href="#" class="nav-link"><i class="icon-images3"></i> <span>Slides</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Cards"
                            @if (Route::is('slides.*')) style="display: block" @endif>
                            @can('add-slide')
                                <li class="nav-item"><a href="{{ route('slides.create') }}"
                                        class="nav-link @if (Route::is('slides.create')) active @endif">Add Slide</a></li>
                            @endcan
                            @can(['edit-slide', 'delete-slide', 'view-slide'])
                                <li class="nav-item"><a href="{{ route('slides.index') }}"
                                        class="nav-link @if (Route::is(['slides.index', 'slides.edit'])) active @endif">Slide List</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can(['add-layout', 'edit-layout', 'delete-layout', 'view-layout'])
                    <li class="nav-item nav-item-submenu @if (Route::is('layouts.*')) nav-item-open @endif">
                        <a href="#" class="nav-link"><i class="icon-images3"></i> <span>Layouts</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Cards"
                            @if (Route::is('layouts.*')) style="display: block" @endif>
                            @can('add-layout')
                                <li class="nav-item"><a href="{{ route('layouts.create') }}"
                                        class="nav-link @if (Route::is('layouts.create')) active @endif">Add Layout</a></li>
                            @endcan
                            @can(['edit-layout', 'delete-layout', 'view-layout'])
                                <li class="nav-item"><a href="{{ route('layouts.index') }}"
                                        class="nav-link @if (Route::is(['layouts.index', 'layouts.edit'])) active @endif">Layout List</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                {{-- @can(['add-media', 'delete-media', 'view-media'])
                    <li class="nav-item nav-item-submenu @if (Route::is('media.*')) nav-item-open @endif">
                        <a href="#" class="nav-link"><i class="icon-film4"></i> <span>Media</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Media"
                            @if (Route::is('media.*')) style="display: block" @endif>
                            @can('add-media')
                                <li class="nav-item"><a href="{{ route('media.create') }}"
                                        class="nav-link @if (Route::is('media.create')) active @endif">Add Media</a></li>
                            @endcan
                            @can(['delete-media', 'view-media'])
                                <li class="nav-item"><a href="{{ route('media.index') }}"
                                        class="nav-link @if (Route::is('media.index')) active @endif">Media List</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan --}}


                @can(['add-permission', 'edit-permission', 'delete-permission', 'view-permission'])
                    <li class="nav-item nav-item-submenu @if (Route::is('permissions.*')) nav-item-open @endif">
                        <a href="#" class="nav-link"><i class="icon-user-lock"></i> <span>Permissions</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Permissions"
                            @if (Route::is('permissions.*')) style="display: block" @endif>
                            @can('add-permission')
                                <li class="nav-item"><a href="{{ route('permissions.create') }}"
                                        class="nav-link @if (Route::is('permissions.create')) active @endif">Add Permission</a>
                                </li>
                                <li class="nav-item"><a href="{{ route('permissions.crud_create') }}"
                                        class="nav-link @if (Route::is('permissions.crud_create')) active @endif">Add CRUD
                                        Permission</a>
                                </li>
                            @endcan
                            @can(['edit-permission', 'delete-permission', 'view-permission'])
                                <li class="nav-item"><a href="{{ route('permissions.index') }}"
                                        class="nav-link @if (Route::is(['permissions.index', 'permissions.edit'])) active @endif">Permission List</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can(['add-role', 'edit-role', 'delete-role', 'view-role'])
                    <li class="nav-item nav-item-submenu @if (Route::is('roles.*')) nav-item-open @endif">
                        <a href="#" class="nav-link"><i class="icon-user-lock"></i> <span>Roles</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Roles"
                            @if (Route::is('roles.*')) style="display: block" @endif>
                            @can('add-role')
                                <li class="nav-item"><a href="{{ route('roles.create') }}"
                                        class="nav-link @if (Route::is('roles.create')) active @endif">Add Role</a></li>
                            @endcan
                            @can(['edit-role', 'delete-role', 'view-role'])
                                <li class="nav-item"><a href="{{ route('roles.index') }}"
                                        class="nav-link @if (Route::is(['roles.index', 'roles.edit'])) active @endif">Role List</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can(['add-user', 'edit-user', 'delete-user', 'view-user'])
                    <li class="nav-item nav-item-submenu @if (Route::is('users.*')) nav-item-open @endif">
                        <a href="#" class="nav-link"><i class="icon-users"></i> <span>Users</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Users"
                            @if (Route::is('users.*')) style="display: block" @endif>
                            @can('add-user')
                                <li class="nav-item"><a href="{{ route('users.create') }}"
                                        class="nav-link @if (Route::is('users.create')) active @endif">Add User</a></li>
                            @endcan
                            @can(['edit-user', 'delete-user', 'view-user'])
                                <li class="nav-item"><a href="{{ route('users.index') }}"
                                        class="nav-link @if (Route::is(['users.index', 'users.edit'])) active @endif">User List</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->
