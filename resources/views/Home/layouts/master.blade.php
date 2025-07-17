<!DOCTYPE html>
<html lang="en">
@include('Home.layouts.head')
<body>
                        @if(session('message'))
    <div class="alert alert-success" style="color: green; font-weight: bold; margin: 10px 0;    margin-left: 36%;">
        {{ session('message') }}
    </div>
@endif
    @include('Home.layouts.header')
    @include('Home.layouts.search-bar')
    @include('Home.layouts.section_part_one')
    @yield('content')
    @include('Home.layouts.footer')
</body>
</html>
