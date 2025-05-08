@extends('Admin.layouts.master')

@section('content')
<section class="table-section" id="comments">
    <h2>مدیریت نظرات</h2>

    <!-- Search and Filter Form -->
    <form method="GET" action="" class="search-form mb-4">
        <div class="form-row">
            <div class="form-group">
                <input type="text" name="search" class="form-control" placeholder="جستجو بر اساس نام" value="{{ request('search') }}">
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
                <th>محتوا</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($comments as $comment)
            <tr>
                <td>{{ $comment->id }}</td>
                <td>{{ optional($comment->user)->name }}</td>
                <td>{{ $comment->content }}</td>
                <td class="action-buttons">
                <a href="{{ route('panel.comment.show', $comment->id) }}" class="btn btn-sm" style="color: #007bff;" title="جزئیات">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="#" 
                       class="btn btn-sm" 
                       style="color: red;" 
                       title="حذف" 
                       onclick="event.preventDefault(); if(confirm('آیا از حذف این نظر مطمئن هستید؟')) {   
                           document.getElementById('delete-form-{{ $comment->id }}').submit(); }">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                    <form id="delete-form-{{ $comment->id }}" action="{{ route('panel.comment.delete', $comment->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">هیچ نظری یافت نشد</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</section>


@endsection