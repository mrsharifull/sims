@auth()
    @include('backend.partials.navbars.navs.auth')
@endauth

@guest()
    @include('backend.partials.navbars.navs.guest')
@endguest
