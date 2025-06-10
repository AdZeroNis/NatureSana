
<aside class="sidebar">
    <h2>پنل مدیریت</h2>
    <ul>
        <li>
            <a href="{{ route('panel.dashboard.index') }}" class="{{ request()->routeIs('panel.dashboard.index') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> داشبورد
            </a>
        </li>
          <li>
            <a href="{{ route('panel.report.index') }}" class="{{ request()->routeIs('panel.report.index') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> گزارش
            </a>
        </li>
        <li>
            <a href="{{ route('store.index') }}" class="{{ request()->routeIs('panel.store.index') ? 'active' : '' }}">
                <i class="fas fa-store"></i> مدیریت مغازه
            </a>
        </li>
        <li>
            <a href="{{ route('panel.partner.index') }}" class="{{ request()->routeIs('panel.partner.index') ? 'active' : '' }}">
                <i class="fas fa-handshake"></i> همکاری
            </a>
        </li>
        <li>
            <a href="{{ route('panel.category.index') }}" class="{{ request()->routeIs('panel.category.index') ? 'active' : '' }}">
                <i class="fas fa-list"></i> دسته‌بندی
            </a>
        </li>
        <li>
            <a href="{{ route('panel.product.index') }}" class="{{ request()->routeIs('panel.product.index') ? 'active' : '' }}">
                <i class="fas fa-leaf"></i> محصولات
            </a>
        </li>
        <li>
            <a href="{{ route('panel.article.index') }}" class="{{ request()->routeIs('panel.article.index') ? 'active' : '' }}">
                <i class="fas fa-newspaper"></i> مقالات
            </a>
        </li>
        <li>
            <a href="{{ route('panel.comment.index') }}" class="{{ request()->routeIs('panel.comment.index') ? 'active' : '' }}">
                <i class="fas fa-comment"></i> نظرات
            </a>
        </li>
        <li>
            <a href="{{ route('panel.cart.index') }}" class="{{ request()->routeIs('panel.cart.index') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i> سبد خرید
            </a>
        </li>
        <li>
            <a href="{{ route('panel.order.index') }}" class="{{ request()->routeIs('panel.order.index') ? 'active' : '' }}">
                <i class="fas fa-box"></i> سفارشات
            </a>
        </li>
        @if(auth()->user()->role == 'super_admin')
        <li>
            <a href="{{ route('panel.slider.index') }}" class="{{ request()->routeIs('panel.slider.index') ? 'active' : '' }}">
                <i class="fas fa-sliders-h"></i> اسلایدرها
            </a>
        </li>
        <li>
            <a href="{{ route('panel.user.index') }}" class="{{ request()->routeIs('panel.user.index') ? 'active' : '' }}">
                <i class="fas fa-users"></i> کاربران
            </a>
        </li>
        @endif
    </ul>
</aside>


