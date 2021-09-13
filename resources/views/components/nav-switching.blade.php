@auth
    <x-nav :user="$user" />
@endauth

@guest
    <x-nav-for-guest />
@endguest
