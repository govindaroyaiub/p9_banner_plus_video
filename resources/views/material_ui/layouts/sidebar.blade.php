<aside class="mdc-drawer mdc-drawer--dismissible mdc-drawer--open">
    <div class="mdc-drawer__header">
        <a href="/" class="brand-logo">
            <img src="{{ asset('logo_images/planetnine.gif') }}" alt="logo" style="width: 93%;">
        </a>
    </div>
    <div class="mdc-drawer__content">
        <div class="user-info">
            <p class="name">{{ $name }}</p>
            <p class="email">{{ $email }}</p>
        </div>
        <div class="mdc-list-group">
            <nav class="mdc-list mdc-drawer-menu">
                <div class="mdc-list-item mdc-drawer-item">
                    <a class="mdc-drawer-link {{ request()->is('/') || request()->is('user/*') ? 'active' : '' }}" href="/">
                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                            aria-hidden="true">home</i>
                        Dashboard
                    </a>
                </div>
                <div class="mdc-list-item mdc-drawer-item">
                    <a class="mdc-drawer-link {{ request()->is('/dashboard2') || request()->is('dashboard2/*') ? 'active' : '' }}" href="/dashboard2">
                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                            aria-hidden="true">home</i>
                        Dashboard 2
                    </a>
                </div>
                <div class="mdc-list-item mdc-drawer-item">
                    <a class="mdc-drawer-link {{ request()->is('view-previews') || request()->is('project/preview/*') ? 'active' : '' }}" href="/view-previews">
                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                            aria-hidden="true">fiber_new</i>
                        New Preview System
                    </a>
                </div>
                <div class="mdc-list-item mdc-drawer-item">
                    <a class="mdc-drawer-link {{ request()->is('p9_transfer') || request()->is('p9_transfer/*') ? 'active' : '' }}" href="/p9_transfer">
                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                            aria-hidden="true">attach_file</i>
                        Files Transfer
                    </a>
                </div>
                <div class="mdc-list-item mdc-drawer-item">
                    <a class="mdc-drawer-link {{ request()->is('bills') || request()->is('bills/*') ? 'active' : '' }}" href="/bills">
                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                        aria-hidden="true">attach_money</i>
                        Bills
                    </a>
                </div>
                <div class="mdc-list-item mdc-drawer-item">
                    <a class="mdc-expansion-panel-link" href="#" data-toggle="expansionPanel"
                        data-target="old_entries_v2">
                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                            aria-hidden="true">pages</i>
                        Old Entries V2
                        <i class="mdc-drawer-arrow material-icons">chevron_right</i>
                    </a>
                    <div class="mdc-expansion-panel" id="old_entries_v2">
                        <nav class="mdc-list mdc-drawer-submenu">
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link {{ request()->is('banner-showcase') || request()->is('project/banner-showcase/*') ? 'active' : '' }}" href="/banner-showcase">
                                    Banner Showcase
                                </a>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link {{ request()->is('video-showcase') || request()->is('project/video-showcase/*') ? 'active' : '' }}" href="/video-showcase">
                                    Video Showcase
                                </a>
                            </div>
                        </nav>
                    </div>
                </div>
                <div class="mdc-list-item mdc-drawer-item">
                    <a class="mdc-expansion-panel-link" href="#" data-toggle="expansionPanel"
                        data-target="old_entries_v1">
                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                            aria-hidden="true">pages</i>
                        Old Entries V1
                        <i class="mdc-drawer-arrow material-icons">chevron_right</i>
                    </a>
                    <div class="mdc-expansion-panel" id="old_entries_v1">
                        <nav class="mdc-list mdc-drawer-submenu">
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link {{ request()->is('banner') || request()->is('project/banner/*') ? 'active' : '' }}" href="/banner">
                                    Banner
                                </a>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link {{ request()->is('video') || request()->is('project/video/*') ? 'active' : '' }}" href="/video">
                                    Video
                                </a>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link {{ request()->is('gif') || request()->is('project/gif/*') ? 'active' : '' }}" href="/gif">
                                    Gif
                                </a>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link {{ request()->is('social') || request()->is('project/social/*') ? 'active' : '' }}" href="/social">
                                    Social
                                </a>
                            </div>
                        </nav>
                    </div>
                </div>
                <div class="mdc-list-item mdc-drawer-item">
                    <a class="mdc-expansion-panel-link" href="#" data-toggle="expansionPanel"
                        data-target="sizes-menu">
                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                            aria-hidden="true">pages</i>
                        Others
                        <i class="mdc-drawer-arrow material-icons">chevron_right</i>
                    </a>
                    <div class="mdc-expansion-panel" id="sizes-menu">
                        <nav class="mdc-list mdc-drawer-submenu">
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link {{ request()->is('banner_sizes') || request()->is('banner_sizes/*') ? 'active' : '' }}" href="/banner-showcase">
                                    Banner & GIF Sizes
                                </a>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link {{ request()->is('sizes') || request()->is('sizes/*') ? 'active' : '' }}" href="/banner-showcase">
                                    Video Sizes
                                </a>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link {{ request()->is('logo') || request()->is('logo/*') ? 'active' : '' }}" href="/logo">
                                    Clients
                                </a>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link {{ request()->is('users') || request()->is('users/*') ? 'active' : '' }}" href="/users">
                                    Users
                                </a>
                            </div>
                        </nav>
                    </div>
                </div>
            </nav>
        </div>
        <div class="profile-actions">
            <a href="/change-password">Change Password</a>
            <span class="divider"></span>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                class="hidden">
                @csrf
            </form>
        </div>
    </div>
</aside>