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


@endsection