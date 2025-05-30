<aside class="sidebar">
    <h2>پنل مدیریت</h2>
    <ul>
        <li><a href="{{route('panel.dashboard.index')}}" class="{{ request()->routeIs('panel.dashboard.index') ? 'active' : '' }}">داشبورد</a></li>
        <li><a href="{{route('store.index')}}" class="{{ request()->routeIs('panel.store.index') ? 'active' : '' }}">مدیریت مغازه</a></li>
        <li><a href="{{route('panel.partner.index')}}" class="{{ request()->routeIs('panel.partner.index') ? 'active' : '' }}">همکاری</a></li>
        <li><a href="{{route('panel.category.index')}}" class="{{ request()->routeIs('panel.category.index') ? 'active' : '' }}">دسته‌بندی</a></li>
        <li><a href="{{route('panel.product.index')}}" class="{{ request()->routeIs('panel.product.index') ? 'active' : '' }}">محصولات</a></li>
        <li><a href="{{route('panel.article.index')}}" class="{{ request()->routeIs('panel.article.index') ? 'active' : '' }}">مقالات</a></li>
        <li><a href="{{route('panel.comment.index')}}" class="{{ request()->routeIs('panel.comment.index') ? 'active' : '' }}">نظرات</a></li>
        <li><a href="{{route('panel.cart.index')}}" class="{{ request()->routeIs('panel.cart.index') ? 'active' : '' }}">سبد خرید</a></li>
        <li><a href="{{route('panel.order.index')}}" class="{{ request()->routeIs('panel.order.index') ? 'active' : '' }}">سفارشات</a></li>
        @if(auth()->user()->role == 'super_admin')
        <li><a href="{{route('panel.slider.index')}}" class="{{ request()->routeIs('panel.slider.index') ? 'active' : '' }}">اسلایدرها</a></li>
        <li><a href="{{route('panel.user.index')}}" class="{{ request()->routeIs('panel.user.index') ? 'active' : '' }}">کاربران</a></li>
        @endif
    </ul>
</aside>