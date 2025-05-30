@extends('Admin.layouts.master')

@section('content')
<section class="comment-details-section py-4">
    <div class="container">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>جزئیات نظر</h2>
            <a href="{{ route('panel.product.comment.show', $comment->product_id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-right ml-1"></i> بازگشت به لیست نظرات
            </a>
        </div>

        <!-- Main Comment Card -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <div>
                    <strong>نویسنده:</strong> {{ $comment->user->name }}
                    <span class="mx-2">|</span>
                    <strong>تاریخ:</strong> {{ \Morilog\Jalali\Jalalian::fromDateTime($comment->created_at)->format('Y/m/d H:i') }}
                </div>
                <div>
                    <strong>محصول:</strong>
                    <a href="{{ route('product.show', $comment->product_id) }}" target="_blank">
                        {{ $comment->product->name }}
                    </a>
                    <span class="mx-2">|</span>
                    <strong>فروشگاه:</strong>
                    <a href="{{ route('store.products', $comment->product->store_id) }}" target="_blank">
                        {{ $comment->product->store->name }}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <p>{{ $comment->content }}</p>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>
                 
                </div>
                <div>
                    <a href="#" class="btn btn-danger"
                        onclick="event.preventDefault(); if(confirm('آیا از حذف این نظر مطمئن هستید؟')) { 
                            document.getElementById('delete-comment-form').submit(); }">
                        <i class="fas fa-trash-alt"></i> حذف نظر
                    </a>
                    <form id="delete-comment-form" action="{{ route('panel.product.comment.delete', $comment->id) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>

        <!-- Reply Form -->
        <div class="collapse mb-4" id="replyForm">
            <div class="card shadow-sm">
            </div>
        </div>
          <!-- Reply Form -->
     <!-- Reply Form -->
<div class="collapse mb-4" id="replyForm">
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('panel.product.comment.reply', $comment->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="reply_content">پاسخ شما:</label>
                    <textarea name="content" id="reply_content" class="form-control" rows="3" required></textarea>
                </div>
                
                <!-- پیش‌نهادات پاسخ سریع -->
                <div class="quick-replies mb-3">
                    <h6 class="mb-2">پاسخ‌های سریع:</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @php
                            $quickReplies = [
                                'با سلام، از نظر شما متشکریم.',
                                'سلام، در اسرع وقت به نظر شما رسیدگی می‌شود.',
                                'با سلام، پیشنهاد شما را بررسی خواهیم کرد.'
                            ];
                        @endphp
                        
                        @foreach($quickReplies as $reply)
                            <button type="button" class="btn btn-outline-primary btn-sm quick-reply-btn" 
                                    data-reply="{{ $reply }}">
                                {{ Str::limit($reply, 30) }}
                            </button>
                        @endforeach
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary mt-2">
                    <i class="fas fa-paper-plane ml-1"></i> ارسال پاسخ
                </button>
            </form>
        </div>
    </div>
</div>

        <!-- Replies Section -->
        <div class="replies-section">
            <h4 class="mb-3">پاسخ‌ها ({{ $comment->replies->count() }})</h4>

            @forelse($comment->replies as $reply)
                <div class="card mb-3 shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <div>
                            <strong>پاسخ از:</strong> {{ $reply->user->name }}
                            <span class="mx-2">|</span>
                            <strong>تاریخ:</strong> {{ \Morilog\Jalali\Jalalian::fromDateTime($reply->created_at)->format('Y/m/d H:i') }}
                        </div>
                        <a href="#" class="btn btn-sm btn-danger"
                            onclick="event.preventDefault(); if(confirm('آیا از حذف این پاسخ مطمئن هستید؟')) { 
                                document.getElementById('delete-reply-form-{{ $reply->id }}').submit(); }">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                        <form id="delete-reply-form-{{ $reply->id }}" action="{{ route('panel.product.comment.delete', $reply->id) }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                    <div class="card-body">
                        <p>{{ $reply->content }}</p>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    هنوز پاسخی برای این نظر ثبت نشده است.
                </div>
            @endforelse
        </div>

    </div>
</section>

<style>
.comment-details-section h2,
.replies-section h4 {
    font-weight: 600;
}
.card {
    border-radius: 10px;
}
.card-header {
    font-size: 0.95rem;
}
textarea.form-control {
    resize: vertical;
}
.quick-replies {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #eee;
}

.quick-reply-btn {
    font-size: 0.8rem;
    padding: 5px 10px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 200px;
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // اضافه کردن پاسخ‌های سریع به textarea
        const quickReplyButtons = document.querySelectorAll('.quick-reply-btn');
        const replyTextarea = document.getElementById('reply_content');
        
        quickReplyButtons.forEach(button => {
            button.addEventListener('click', function() {
                replyTextarea.value = this.getAttribute('data-reply');
                // اسکرول به textarea
                replyTextarea.focus();
            });
        });
    });
</script>

@endsection