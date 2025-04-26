<aside class="sidebar">
    <h2>پنل مدیریت</h2>
    <ul>
        <li><a href="{{route('panel.dashboard.index')}}" class="{{ request()->routeIs('panel.dashboard.index') ? 'active' : '' }}">داشبورد</a></li>

        <li><a href="{{route('store.index')}}" class="{{ request()->routeIs('panel.store.index') ? 'active' : '' }}">مدیریت مغازه</a></li>
        <li><a href="{{route('panel.category.index')}}" class="{{ request()->routeIs('panel.category.index') ? 'active' : '' }}">دسته‌بندی</a></li>
    </ul>
</aside>
