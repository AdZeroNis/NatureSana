<header>
    <nav>
        <div class="logo">NatureSana </div>
        <ul id="nav-menu">
            {{-- <li><a href="{{ route('article.index') }}" title="مقالات">مقالات</a></li> --}}
            <li>    <a href="{{ route('cart.showCart') }}" title="سبد خرید">
        <i > سبد خرید</i></a></li>

            <li class="user-dropdown">
                @auth
                    <a href="#" class="user-profile" title="پروفایل کاربری">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        @if(auth()->user()->role == 'super_admin')
                            <li><a href="{{ route('panel.dashboard.index') }}">پنل ادمین</a></li>
                            <li><a href="{{ route('profile') }}">پروفایل</a></li>
                            <li><a href="{{ route('logout') }}">خروج</a></li>
                            {{-- <li><a href="{{route('cart.showCart')}}">سبد خرید</a></li> --}}
                            <li><a href="{{route('order.index')}}">سفارشات</a></li>
                        @elseif(auth()->user()->role == 'admin')
                            <li><a href="{{ route('profile') }}">پروفایل</a></li>
                            {{-- <li><a href="{{route('cart.showCart')}}">سبد خرید</a></li> --}}
                            <li><a href="{{route('order.index')}}">سفارشات</a></li>
                            <li><a href="{{ route('panel.dashboard.index') }}">مغازه</a></il>
                            <li><a href="{{ route('logout') }}">خروج</a></li>
                        @else
                            <li><a href="{{ route('profile') }}">پروفایل</a></li>
                            {{-- <li><a href="{{route('cart.showCart')}}">سبد خرید</a></li> --}}
                            <li><a href="{{route('order.index')}}">سفارشات</a></li>
                            <li><a href="{{ route('logout') }}">خروج</a></li>
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
