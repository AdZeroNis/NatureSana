<!DOCTYPE html>
<html lang="en">
@include('Admin.layouts.head')
<body>
    <div class="admin-container">
        @include('Admin.layouts.sidebar')
        <main class="main-content">
            @include('Admin.layouts.headr')
            @yield('content')
            {{-- @include('Admin.dashboard') --}}
        </main>
    </div>
</body>
@include('Admin.layouts.js')
</html>
