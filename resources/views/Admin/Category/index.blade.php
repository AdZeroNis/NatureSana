@extends('Admin.layouts.master')

@section('content')
<section class="table-section" id="categories">
    <h2>مدیریت دسته‌بندی‌ها</h2>

    <!-- Search and Filter Form -->
    <form method="GET" action="{{ route('panel.category.filter') }}" class="search-form mb-4">
        <div class="form-row">
            <div class="form-group">
                <input type="text" name="search" class="form-control" placeholder="جستجو بر اساس نام دسته‌بندی" value="{{ request('search') }}">
            </div>
            <div class="form-group">
                <select name="status" class="form-control">
                    <option value="">تمام وضعیت‌ها</option>
                    <option value="active" {{ request('status') == '1' ? 'selected' : '' }}>فعال</option>
                    <option value="inactive" {{ request('status') == '0' ? 'selected' : '' }}>غیرفعال</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-search">جستجو</button>
            </div>
        </div>
    </form>

    <div class="add-item my-3">
        <a href="{{ route('panel.category.create') }}" class="btn btn-add">افزودن دسته‌بندی جدید</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>شناسه</th>
                <th>نام</th>
                @if(Auth::user()->role == 'super_admin')
                <th>مغازه</th>
                @endif
                <th>وضعیت</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                @if(Auth::user()->role == 'super_admin')
                <td>{{ $category->store ? $category->store->name : 'N/A' }}</td>
                @endif
                <td class="text-center">
                    <span class="badge badge-{{ $category->status == '1' ? 'success' : 'danger' }}">
                        {{ $category->status == '1' ? 'فعال' : 'غیرفعال' }}
                    </span>
                </td>
                <td class="action-buttons">
                    <a href="{{ route('panel.category.edit', $category->id) }}" class="btn btn-sm" style="color: hotpink;" title="ویرایش">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button type="button"
                        class="btn btn-sm"
                        style="color: red; border: none; background: none; padding: 0; {{ !$category->isDeletable() ? 'opacity: 0.5;' : '' }}"
                        title="حذف"
                        onclick="if(confirm('آیا از حذف این دسته‌بندی مطمئن هستید؟')) {
                            document.getElementById('delete-form-{{ $category->id }}').submit(); }"
                        @disabled(!$category->isDeletable())>
                        <i class="fas fa-trash-alt"></i>
                    </button>

                    <form id="delete-form-{{ $category->id }}"   action="{{ route('panel.category.delete', $category->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="@if(Auth::user()->role == 'super_admin')5 @else4 @endif" class="text-center">هیچ دسته‌بندی یافت نشد</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</section>

@endsection