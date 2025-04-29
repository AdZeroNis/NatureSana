@extends('Admin.layouts.master')

@section('content')
<section class="table-section" id="stores">
    <h2>مدیریت مغازه‌ها</h2>

    <!-- Search and Filter Form -->
    <form method="GET" action="{{ route('store.filter') }}" class="search-form mb-4">
        <div class="form-row">
            <div class="form-group">
                <input type="text" name="search" class="form-control" placeholder="جستجو بر اساس نام مغازه" value="{{ request('search') }}">
            </div>
            <div class="form-group">
                <select name="status" class="form-control">
                    <option value="">وضعیت فعال/غیرفعال</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>فعال</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غیرفعال</option>
                </select>
            </div>
         
            <div class="form-group">
                <button type="submit" class="btn btn-search">جستجو</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>شناسه</th>
                <th>نام</th>
                <th>وضعیت</th>
                <th>وضعیت تایید</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($stores as $store)
            <tr>
                <td>{{ $store->id }}</td>
                <td>{{ $store->name }}</td>
                <td class="text-center">
                    <span class="badge badge-{{ $store->status == '1' ? 'success' : 'danger' }}">
                        {{ $store->status == '1' ? 'فعال' : 'غیرفعال' }}
                    </span>
                </td>
                <td class="text-center">
                    @if($store->is_approved === null)
                        <span class="badge badge-warning">در انتظار تایید</span>
                    @elseif($store->is_approved)
                        <span class="badge badge-success">تایید شده</span>
                    @else
                        <span class="badge badge-danger">رد شده</span>
                    @endif
                </td>
                <td class="action-buttons">
                    @if($store->is_approved === null)
                        <form action="{{ route('store.approve', $store->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success" title="تایید">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        <form action="{{ route('store.reject', $store->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger" title="رد">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('store.show', $store->id) }}" class="btn btn-sm" style="color: #007bff;" title="جزئیات">
                        <i class="fas fa-eye"></i>
                    </a>

                    <a href="{{ route('store.edit', $store->id) }}" class="btn btn-sm" style="color: hotpink;" title="ویرایش">
                        <i class="fas fa-edit"></i>
                    </a>
                    @if($user->role === 'super_admin')
                    <a href="#" 
                       class="btn btn-sm" 
                       style="color: red;" 
                       title="حذف" 
                       onclick="event.preventDefault(); if(confirm('آیا از حذف این مغازه مطمئن هستید؟')) { 
                           document.getElementById('delete-form-{{ $store->id }}').submit(); }">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                    @endif

                    <form id="delete-form-{{ $store->id }}" action="{{ route('store.delete', $store->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">هیچ مغازه‌ای یافت نشد</td>
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

    .badge-success { background: #28a745; color: white; }
    .badge-danger { background: #dc3545; color: white; }
    .badge-warning { background: #ffc107; color: black; }

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