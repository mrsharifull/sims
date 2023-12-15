<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="{{ route('dashboard') }}" class="simple-text logo-mini">{{ _('SIMS') }}</a>
            <a href="{{ route('dashboard') }}" class="simple-text logo-normal">{{ _('Dashboard') }}</a>
        </div>
        <ul class="nav">
            @include('backend.partials.menu_buttons', [
                'menuItems' => [
                    ['pageSlug' => 'dashboard', 'routeName' => 'dashboard', 'iconClass' => 'fa-solid fa-chart-line', 'label' => 'Dashboard'],
                    ]
               ])


            {{-- User Management --}}
            <li>
                <a class="@if(
                        $pageSlug == 'role' ||
                        $pageSlug == 'permission'||
                        $pageSlug == 'user'
                    )@else collapsed @endif" data-toggle="collapse" href="#user-management" @if (
                        $pageSlug == 'role' ||
                        $pageSlug == 'permission'||
                        $pageSlug == 'user'
                    ) aria-expanded='true' @else aria-expanded='false' @endif>
                    
                    <i class="fa-solid fa-users-gear"></i>
                    <span class="nav-link-text" >{{ __('User Management') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse @if (
                    $pageSlug == 'role' ||
                    $pageSlug == 'permission'||
                    $pageSlug == 'user'
                ) show @endif" id="user-management">
                    <ul class="nav pl-2">
                        @include('backend.partials.menu_buttons', [
                            'menuItems' => [
                                ['pageSlug' => 'user', 'routeName' => 'um.user.user_list', 'label' => 'Users'],
                                ['pageSlug' => 'role', 'routeName' => 'um.role.role_list', 'label' => 'Roles'],
                                ['pageSlug' => 'permission', 'routeName' => 'um.permission.permission_list', 'label' => 'Permission'],
                            ]
                        ])
                    </ul>
                </div>
            </li>


            
            {{-- <li @if ($pageSlug == 'icons') class="active " @endif>
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
            </li> --}}
        </ul>
    </div>
</div>
