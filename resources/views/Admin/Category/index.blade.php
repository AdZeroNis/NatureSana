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
                    <a href="{{ route('panel.category.edit', $category->id) }}" class="btn btn-sm" style="color: hotpink;" title="ویرایش">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="#" 
                       class="btn btn-sm" 
                       style="color: red;" 
                       title="حذف" 
                       onclick="event.preventDefault(); if(confirm('آیا از حذف این دسته‌بندی مطمئن هستید؟')) { 
                           document.getElementById('delete-form-{{ $category->id }}').submit(); }">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                    <form id="delete-form-{{ $category->id }}" action="{{ route('panel.category.delete', $category->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
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

<style>
    .table-section {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        max-width: 1200px;
        margin: 3rem auto;
    }

    .table-section h2 {
        font-family: 'Vazir', sans-serif;
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        text-align: center;
        font-size: 1.5rem;
    }

    .search-form .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: center;
    }

    .search-form .form-group {
        flex: 1;
        min-width: 200px; /* حداقل عرض برای جلوگیری از کوچک شدن بیش از حد */
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-family: 'Vazir', sans-serif;
        font-size: 1rem;
    }

    .btn-search {
        padding: 0.75rem 2rem;
        background: var(--accent-color);
        color: white;
        border: none;
        border-radius: 25px;
        font-family: 'Vazir', sans-serif;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .btn-search:hover {
        background: var(--secondary-color);
    }

    .btn-add {
        padding: 0.75rem 2rem;
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: 25px;
        font-family: 'Vazir', sans-serif;
        text-decoration: none;
        display: inline-block;
        transition: background 0.3s ease;
    }

    .btn-add:hover {
        background: var(--secondary-color);
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Vazir', sans-serif;
    }

    .table th, .table td {
        padding: 1rem;
        text-align: center;
        border: 1px solid #ddd;
    }

    .table th {
        background: var(--primary-color);
        color: white;
    }

    .badge {
        padding: 0.5rem 1rem;
        border-radius: 15px;
        font-size: 0.9rem;
    }

    .badge-success {
        background: #28a745;
        color: white;
    }

    .badge-danger {
        background: #dc3545;
        color: white;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .search-form .form-row {
            flex-direction: column;
            align-items: stretch;
        }

        .search-form .form-group {
            min-width: 100%;
        }

        .table-section {
            margin: 1rem;
            padding: 1.5rem;
        }
    }
</style>
@endsection