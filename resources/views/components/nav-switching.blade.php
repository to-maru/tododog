@auth
    <x-nav :user="$user" />
@endauth

@guest
    <x-nav-to-login />
@endguest
