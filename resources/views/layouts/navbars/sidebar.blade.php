<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="{{ route('dashboard') }}" class="simple-text logo-mini">{{ _('SIMS') }}</a>
            <a href="{{ route('dashboard') }}" class="simple-text logo-normal">{{ _('Dashboard') }}</a>
        </div>
        <ul class="nav">
            <!-- <li @if ($pageSlug == 'dashboard') class="active " @endif>
                <a href="{{ route('dashboard') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ _('Dashboard') }}</p>
                </a>
            </li> -->
            <li>
                <a data-toggle="collapse" href="#um" 
                    @if (
                    $pageSlug == 'user' ||
                    $pageSlug == 'role' ||
                    $pageSlug == 'permission'
                    )  
                        aria-expanded="true"
                    @endif
                     >
                    <i class="fa-solid fa-users
                    @if (
                    $pageSlug == 'user' ||
                    $pageSlug == 'role' ||
                    $pageSlug == 'permission'
                    )  
                        fa-beat
                    @endif
                     "></i>
                    <span class="nav-link-text" >{{ __('User Management') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse
                    @if (
                    $pageSlug == 'user' ||
                    $pageSlug == 'role' ||
                    $pageSlug == 'permission'
                    )  
                        show
                    @endif
                     " id="um">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'user') class="active " @endif>
                            <a href="{{ route('um.user.index')  }}">
                                <i class="fas fa-minus"></i>
                                <p>{{ _('User') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'role') class="active " @endif>
                            <a href="{{ route('user.index')  }}">
                                <i class="fas fa-minus"></i>
                                <p>{{ _('Role') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'permission') class="active " @endif>
                            <a href="{{ route('user.index')  }}">
                                <i class="fas fa-minus"></i>
                                <p>{{ _('Permission') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- <li @if ($pageSlug == 'icons') class="active " @endif>
                <a href="{{ route('pages.icons') }}">
                    <i class="tim-icons icon-atom"></i>
                    <p>{{ _('Icons') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'maps') class="active " @endif>
                <a href="{{ route('pages.maps') }}">
                    <i class="tim-icons icon-pin"></i>
                    <p>{{ _('Maps') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'notifications') class="active " @endif>
                <a href="{{ route('pages.notifications') }}">
                    <i class="tim-icons icon-bell-55"></i>
                    <p>{{ _('Notifications') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'tables') class="active " @endif>
                <a href="{{ route('pages.tables') }}">
                    <i class="tim-icons icon-puzzle-10"></i>
                    <p>{{ _('Table List') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'typography') class="active " @endif>
                <a href="{{ route('pages.typography') }}">
                    <i class="tim-icons icon-align-center"></i>
                    <p>{{ _('Typography') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'rtl') class="active " @endif>
                <a href="{{ route('pages.rtl') }}">
                    <i class="tim-icons icon-world"></i>
                    <p>{{ _('RTL Support') }}</p>
                </a>
            </li>
            <li class=" {{ $pageSlug == 'upgrade' ? 'active' : '' }} bg-info">
                <a href="{{ route('pages.upgrade') }}">
                    <i class="tim-icons icon-spaceship"></i>
                    <p>{{ _('Upgrade to PRO') }}</p>
                </a>
            </li> -->
        </ul>
    </div>
</div>
