<header>
    <nav>
        <div class="logo">گیاهان دارویی</div>
        <ul id="nav-menu">
            <li><a href="{{ route('home') }}" title="خانه"><i class="fas fa-home"></i></a></li>
            <li><a href="#shop" title="فروشگاه"><i class="fas fa-store"></i></a></li>
            <li><a href="{{ route('article.index') }}" title="مقالات"><i class="fas fa-book-open"></i></a></li>
            <li class="user-dropdown">
                @auth
                    <a href="#" class="user-profile" title="پروفایل کاربری">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        @if(auth()->user()->role == 'super_admin')
                            <li><a href="{{ route('panel.dashboard.index') }}">پنل ادمین</a></li>
                            <li><a href="#">پروفایل</a></li>
                            <li><a href="#">سفارشات</a></li>
                        @elseif(auth()->user()->role == 'admin')
                            <li><a href="#">پروفایل</a></li>
                            <li><a href="#">سفارشات</a></li>
                            <li><a href="{{ route('panel.dashboard.index') }}">مغازه</a></il>
                        @else
                            <li><a href="#">پروفایل</a></li>
                            <li><a href="#">سفارشات</a></li>
                        @endif
                    </ul>
                @else
                    <a href="{{ route('login') }}" title="حساب کاربری">
                        <i class="fas fa-user"></i>
                    </a>
                @endauth
            </li>
        </ul>
    </nav>
</header>
