<!DOCTYPE html>
<html lang="en">
@include('Home.layouts.head')
<body>
    @include('Home.layouts.header')
    @include('Home.layouts.search-bar')
    @include('Home.layouts.section_part_one')
    @yield('content')
    @include('Home.layouts.footer')
</body>
</html>