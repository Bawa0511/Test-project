@include('layouts.header')

@stack('topscripts')

@yield('content')

@stack('scripts')

@include('layouts.footer')