<!DOCTYPE html>
<html lang="en">
@include('Auth.layouts.head')
<body>
<div class="auth-container">
    @yield('content')
</div>
</body>
@include('Auth.layouts.js')
</html>