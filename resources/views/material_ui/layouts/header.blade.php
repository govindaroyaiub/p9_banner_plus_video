<header class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <div class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <button
                class="material-icons mdc-top-app-bar__navigation-icon mdc-icon-button sidebar-toggler">menu</button>
            <span class="mdc-top-app-bar__title">Greetings {{ $name }}!</span>
        </div>
        <div
            class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end mdc-top-app-bar__section-right">
            <div class="menu-button-container menu-profile d-none d-md-block">
                <button class="mdc-button mdc-menu-button">
                    <span class="d-flex align-items-center">
                        <span class="user-name">{{ $name }}</span>
                    </span>
                </button>
                <div class="mdc-menu mdc-menu-surface" tabindex="-1">
                    <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical">
                        <li class="mdc-list-item" role="menuitem">
                            <div class="item-thumbnail item-thumbnail-icon-only">
                                <i class="mdi mdi-account-edit-outline text-primary"></i>
                            </div>
                            <div
                                class="item-content d-flex align-items-start flex-column justify-content-center">
                                <h6 class="item-subject font-weight-normal">
                                    <a href="/change-password">
                                        Change Password
                                    </a>
                                </h6>
                            </div>
                        </li>
                        <li class="mdc-list-item" role="menuitem">
                            <div class="item-thumbnail item-thumbnail-icon-only">
                                <i class="mdi mdi-logout text-primary"></i>
                            </div>
                            <div
                                class="item-content d-flex align-items-start flex-column justify-content-center">
                                <h6 class="item-subject font-weight-normal">
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="hidden">
                                        @csrf
                                    </form>
                                </h6>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="divider d-none d-md-block"></div>
        </div>
    </div>
</header>