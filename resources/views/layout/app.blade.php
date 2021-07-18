<!doctype html>
<html lang="en">
@include('layout.partials.header')
<body>

<div class="container px-4">
    @include('nav.main')
    @yield('content')

    @include('layout.partials.footer')
</div>
</body>
</html>

