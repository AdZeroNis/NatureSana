<!DOCTYPE html>
<html lang="en">
@include('Admin.layouts.head')
<body>
    <div class="admin-container">
        @include('Admin.layouts.sidebar')
        <main class="main-content">
            @include('Admin.layouts.headr')
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            @yield('content')
            {{-- @include('Admin.dashboard') --}}
        </main>
    </div>
</body>
@include('Admin.layouts.js')
@yield('scripts')
</html>
