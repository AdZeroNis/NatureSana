<header>
    <nav>
        <div class="logo">NatureSana </div>
        <ul id="nav-menu">
            <li><a href="{{ route('home') }}" title="خانه">خانه</a></li>
            <li><a href="#shop" title="محصولات">محصولات</a></li>
            <li><a href="{{ route('article.index') }}" title="مقالات">مقالات</a></li>
            <li class="user-dropdown">
                @auth
                    <a href="#" class="user-profile" title="پروفایل کاربری">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        @if(auth()->user()->role == 'super_admin')
                            <li><a href="{{ route('panel.dashboard.index') }}">پنل ادمین</a></li>
                            <li><a href="{{ route('profile') }}">پروفایل</a></li>
                            <li><a href="#">سفارشات</a></li>
                        @elseif(auth()->user()->role == 'admin')
                            <li><a href="{{ route('profile') }}">پروفایل</a></li>
                            <li><a href="#">سفارشات</a></li>
                            <li><a href="{{ route('panel.dashboard.index') }}">مغازه</a></il>
                        @else
                            <li><a href="{{ route('profile') }}">پروفایل</a></li>
                            <li><a href="#">سفارشات</a></li>
                        @endif
                    </ul>
                @else
                    <a href="{{ route('login') }}" title="حساب کاربری">
                        حساب کاربری
                    </a>
                @endauth
            </li>
        </ul>
    </nav>
</header>
