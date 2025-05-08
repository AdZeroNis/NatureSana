@extends('Admin.layouts.master')

@section('content')
<section class="table-section" id="products">
    <h2>مدیریت محصولات</h2>             

    <!-- Search and Filter Form -->
    <form method="GET" action="{{ route('panel.product.filter') }}" class="search-form mb-4">
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
        <a href="{{ route('panel.product.create') }}" class="btn btn-add">افزودن محصول جدید</a>
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
            @forelse($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td class="text-center">
                    <span class="badge badge-{{ $product->status == '1' ? 'success' : 'danger' }}">
                        {{ $product->status == '1' ? 'فعال' : 'غیرفعال' }}
                    </span>
                </td>
                <td class="action-buttons">
                <a href="{{ route('panel.product.show', $product->id) }}" class="btn btn-sm" style="color: #007bff;" title="جزئیات">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('panel.product.edit', $product->id) }}" class="btn btn-sm" style="color: hotpink;" title="ویرایش">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="#" 
                       class="btn btn-sm" 
                       style="color: red;" 
                       title="حذف" 
                       onclick="event.preventDefault(); if(confirm('آیا از حذف این محصول مطمئن هستید؟')) { 
                           document.getElementById('delete-form-{{ $product->id }}').submit(); }">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                 
                    <form id="delete-form-{{ $product->id }}" action="{{ route('panel.product.delete', $product->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">هیچ محصولی یافت نشد</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</section>


@endsection