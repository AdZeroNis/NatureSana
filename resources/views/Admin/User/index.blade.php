@extends('Admin.layouts.master')

@section('content')
<section class="table-section" id="categories">
    <h2>مدیریت کاربران</h2>

    <!-- Search and Filter Form -->
    <form method="GET" action="{{ route('panel.user.filter') }}" class="search-form mb-4">
        <div class="form-row">
            <div class="form-group">
                <input type="text" name="search" class="form-control" placeholder="جستجو بر اساس نام کاربر" value="{{ request('search') }}">
            </div>
            <div class="form-group">
                <select name="role" class="form-control">
                    <option value="">تمام نقش ها</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>ادمین</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>کاربر</option>
                </select>
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
        <a href="{{ route('panel.user.create') }}" class="btn btn-add">افزودن کاربر جدید</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>شناسه</th>
                <th>نام</th>
                <th>شماره تماس</th>
                <th>نقش</th>
                <th>وضعیت</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->phone }}</td>
                @if($user->role == 'super_admin')
                    <td>سوپر ادمین</td>
                @elseif($user->role == 'admin')
                    <td>ادمین</td>
                @elseif($user->role == 'user')
                    <td>کاربر</td>
                @endif
                <td class="text-center">
                    <span class="badge badge-{{ $user->status == '1' ? 'success' : 'danger' }}">
                        {{ $user->status == '1' ? 'فعال' : 'غیرفعال' }}
                    </span>
                </td>
                <td class="action-buttons">
    @if($user->id != auth()->id())
    <a href="{{ route('panel.user.show', $user->id) }}" class="btn btn-sm" style="color: #007bff;" title="جزئیات">
                        <i class="fas fa-eye"></i>
                    </a>
        <a href="{{ route('panel.user.edit', $user->id) }}" class="btn btn-sm" style="color: hotpink;" title="ویرایش">
            <i class="fas fa-edit"></i>
        </a>
        <a href="#" 
           class="btn btn-sm" 
           style="color: red;" 
           title="حذف" 
           onclick="event.preventDefault(); if(confirm('آیا از حذف این کاربر مطمئن هستید؟')) { 
               document.getElementById('delete-form-{{ $user->id }}').submit(); }">
            <i class="fas fa-trash-alt"></i>
        </a>
        <form id="delete-form-{{ $user->id }}" action="{{ route('panel.user.delete', $user->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @else
        <span class="text-muted">غیرفعال</span>
    @endif
</td>

            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">هیچ کاربری یافت نشد</td>
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