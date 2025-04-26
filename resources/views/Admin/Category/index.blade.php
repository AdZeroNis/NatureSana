
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
                <th>وضعیت</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td class="text-center">
                    <span class="badge badge-{{ $category->status == '1' ? 'success' : 'danger' }}">
                        {{ $category->status == '1' ? 'فعال' : 'غیرفعال' }}
                    </span>
                </td>
                <td class="action-buttons">
                    <a href="{{ route('panel.category.edit', $category->id) }}" class="btn btn-sm btn-edit">ویرایش</a>
                    <form action="{{ route('panel.category.delete', $category->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-delete" onclick="return confirm('آیا از حذف این دسته‌بندی مطمئن هستید؟')">حذف</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">هیچ دسته‌بندی یافت نشد</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</section>


@endsection

