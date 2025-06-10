@extends('Admin.layouts.master')

@section('content')
<section class="table-section" id="comments">
    <h2>مدیریت نظرات</h2>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>شناسه</th>
                <th>نام</th>
                <th>محتوا</th>
                <th>پاسخ ادمین</th>
                <th>تاریخ ثبت</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($comments as $comment)
            <tr>
                <td>{{ $comment->id }}</td>
                <td>{{ optional($comment->user)->name }}</td>
                <td>{{ $comment->content }}</td>
                <td class="text-center">
                    @if(app(App\Http\Controllers\Home\ProductCommentController::class)->hasAdminReply($comment))
                        <i class="fas fa-check text-success" title="پاسخ داده شده"></i>
                    @else
                        <i class="fas fa-times text-muted" title="بدون پاسخ"></i>
                    @endif
                </td>
                <td>{{ \Morilog\Jalali\Jalalian::fromDateTime($comment->created_at)->format('Y/m/d H:i') }}</td>
                <td class="action-buttons">
                <a href="{{ route('panel.product.comment.show', $comment->id) }}" class="btn btn-sm" style="color: #007bff;" title="جزئیات">
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
                    <form id="delete-form-{{ $comment->id }}" action="{{ route('panel.product.comment.delete', $comment->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">هیچ نظری یافت نشد</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</section>


@endsection
