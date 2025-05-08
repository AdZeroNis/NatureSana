@extends('Admin.layouts.master')

@section('content')
<section class="table-section" id="articles">
    <h2>مدیریت مقالات</h2>

    <!-- Search and Filter Form -->
    <form method="GET" action="{{ route('panel.article.filter') }}" class="search-form mb-4">
        <div class="form-row">
            <div class="form-group">
                <input type="text" name="search" class="form-control" placeholder="جستجو بر اساس عنوان مقاله" value="{{ request('search') }}">
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
        <a href="{{ route('panel.article.create') }}" class="btn btn-add">افزودن مقاله جدید</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>شناسه</th>
                <th>عنوان</th>
                <th>وضعیت</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($articles as $article)
            <tr>
                <td>{{ $article->id }}</td>
                <td>{{ $article->title }}</td>
                <td class="text-center">
                    <span class="badge badge-{{ $article->status == '1' ? 'success' : 'danger' }}">
                        {{ $article->status == '1' ? 'فعال' : 'غیرفعال' }}
                    </span>
                </td>
                <td class="action-buttons">
                    <a href="{{ route('panel.article.show', $article->id) }}" class="btn btn-sm" style="color: #007bff;" title="جزئیات">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('panel.article.edit', $article->id) }}" class="btn btn-sm" style="color: hotpink;" title="ویرایش">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="#" 
                       class="btn btn-sm" 
                       style="color: red;" 
                       title="حذف" 
                       onclick="event.preventDefault(); if(confirm('آیا از حذف این مقاله مطمئن هستید؟')) { 
                           document.getElementById('delete-form-{{ $article->id }}').submit(); }">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                    <form id="delete-form-{{ $article->id }}" action="{{ route('panel.article.delete', $article->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">هیچ مقاله‌ای یافت نشد</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</section>
@endsection