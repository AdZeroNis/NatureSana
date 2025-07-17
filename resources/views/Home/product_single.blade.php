<!DOCTYPE html>
<html lang="en">
    @include('Home.layouts.head')
<body>
    @include('Home.layouts.header')

<section class="single-product-section">
        @if(session('success'))
        <div class="alert alert-success" style="color: green; background-color: #e6ffe6; padding: 15px; border-radius: 5px; margin: 15px auto; width: 100%; max-width: 1000px; text-align: center;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="color: red; background-color: #ffe6e6; padding: 15px; border-radius: 5px; margin: 15px auto; width: 100%; max-width: 1000px; text-align: center;">
            {{ session('error') }}
        </div>
    @endif
    <div class="container">
        <div class="product-header">
            <h1>{{ $product->name }}</h1>
        </div>

        <div class="product-details">
            <div class="product-image">
                @if($product->image)
                    <a href="{{ asset('AdminAssets/Product-image/' . $product->image) }}" data-lightbox="product-gallery" data-title="{{ $product->name }}">
                        <img src="{{ asset('AdminAssets/Product-image/' . $product->image) }}" alt="{{ $product->name }}">
                    </a>
                @else
                    <div class="no-image">
                        <i class="fas fa-box"></i>
                    </div>
                @endif
            </div>

            <div class="product-info">
                <div class="info-row">
                    <span class="label"><i class="fas fa-tag"></i> قیمت:</span>
                    <span class="value">{{ number_format($product->price, 0) }} تومان</span>
                </div>
                <div class="info-row">
                    <span class="label"><i class="fas fa-folder"></i> دسته‌بندی:</span>
                    <span class="value">{{ $product->category ? $product->category->name : 'بدون دسته‌بندی' }}</span>
                </div>
                <div class="info-row">
                    <span class="label"><i class="fas fa-store"></i> فروشگاه:</span>
                    <span class="value">{{ $product->store ? $product->store->name : 'بدون فروشگاه' }}</span>
                </div>
                <div class="info-row">
    <span class="label"><i class="fas fa-handshake"></i> همکاری:</span>
    <span class="value">

    </span>
</div>

              <div class="info-row">
    <span class="label"><i class="fas fa-align-right"></i> توضیحات:</span>
    <span class="value" style="white-space: pre-line;">{{ $product->description ?: 'بدون توضیحات' }}</span>
</div>

@if ($product->inventory > 0 && $product->status == 1 && $product->store->status == 1)
    @php
        $partnerProduct = $product->sharedPartnerships->first();
        $partnerStoreActive = true;

        if ($partnerProduct) {
            $partnerStore = \App\Models\Store::find($partnerProduct->partner_store_id);
            $partnerStoreActive = $partnerStore && $partnerStore->status == 1;
        }
    @endphp

    @if(!$partnerProduct || ($partnerProduct && $partnerStoreActive))
        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
            @csrf
            @if($partnerProduct)
                <input type="hidden" name="partner_product_id" value="{{ $partnerProduct->pivot->id }}">
                <input type="hidden" name="partner_store_id" value="{{ $partnerProduct->partner_store_id }}">
            @endif
            <button type="submit" class="add-to-cart-btn">افزودن به سبد خرید</button>
        </form>
    @else
        <button class="add-to-cart-btn" disabled>فروشگاه شریک غیرفعال است</button>
    @endif
@else
    @if($product->store->status == 0)
        <button class="add-to-cart-btn" disabled>فروشگاه غیرفعال است</button>
    @elseif($product->status == 0)
        <button class="add-to-cart-btn" disabled>محصول غیرفعال است</button>
    @else
        <button class="add-to-cart-btn" disabled>ناموجود</button>
    @endif
@endif


            </div>
        </div>

        <!-- بخش نظرات کاربران -->
        <div class="comments-section">
            <h2>نظرات کاربران</h2>
            <!-- فرم ارسال نظر -->
            <div class="comment-form">
                @if(auth()->check())
                    <form action="{{ route('product.comment.store', $product->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="content">نظر شما:</label>
                            <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="submit-comment-btn">ارسال نظر</button>
                    </form>
                @else
                    <p>برای ارسال نظر، لطفاً <a href="{{ route('login') }}">وارد شوید</a>.</p>
                @endif
            </div>


        <!-- لیست نظرات -->

<div class="comments-list">
    @forelse($product->productcomments->where('parent_id', null) as $comment)
        <div class="comment" data-comment-id="{{ $comment->id }}">
            <div class="comment-header">
                <span class="comment-author">{{ $comment->user->name }}</span>
                <span class="comment-date">{{ \Morilog\Jalali\Jalalian::fromDateTime($comment->created_at)->format('Y/m/d H:i') }}</span>
            </div>
            <p class="comment-body">{{ $comment->content }}</p>
            @if(auth()->check())
                <button class="reply-toggle-btn" data-comment-id="{{ $comment->id }}">پاسخ</button>
                <form action="{{ route('product.comment.reply', $comment->id) }}" method="POST" class="reply-form" id="reply-form-{{ $comment->id }}" style="display: none;">
                    @csrf
                    <div class="form-group">
                        <textarea name="content" class="form-control" rows="3" required placeholder="پاسخ خود را بنویسید..."></textarea>
                    </div>
                    <button type="submit" class="submit-reply-btn">ارسال پاسخ</button>
                </form>
            @else
                <p class="reply-login-message">برای پاسخ به این نظر، لطفاً <a href="{{ route('login') }}">وارد شوید</a>.</p>
            @endif

            <!-- نمایش پاسخ‌ها -->
            @if($comment->replies->isNotEmpty())
                <div class="replies-container" id="replies-{{ $comment->id }}">
                    @foreach($comment->replies->take(1) as $reply) <!-- نمایش فقط یک پاسخ به‌صورت پیش‌فرض -->
                        <div class="reply" data-reply-id="{{ $reply->id }}">
                            <div class="comment-header">
                                <span class="comment-author">
                                    {{ $reply->user->name }}
                                    @if($reply->user->role === 'admin' || $reply->user->role === 'super_admin')
                                        <span class="admin-badge">مدیر</span>
                                    @endif
                                </span>
                                <span class="comment-date">{{ \Morilog\Jalali\Jalalian::fromDateTime($reply->created_at)->format('Y/m/d H:i') }}</span>
                            </div>
                            <p class="comment-body">{{ $reply->content }}</p>
                            @if(auth()->check())
                                <button class="reply-toggle-btn" data-comment-id="{{ $reply->id }}">پاسخ</button>
                                <form action="{{ route('product.comment.reply', $comment->id) }}" method="POST" class="reply-form" id="reply-form-{{ $reply->id }}" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="reply_to" value="{{ $reply->id }}">
                                    <div class="form-group">
                                        <textarea name="content" class="form-control" rows="3" required placeholder="پاسخ به {{ $reply->user->name }}..."></textarea>
                                    </div>
                                    <button type="submit" class="submit-reply-btn">ارسال پاسخ</button>
                                </form>
                            @else
                                <p class="reply-login-message">برای پاسخ به این نظر، لطفاً <a href="{{ route('login') }}">وارد شوید</a>.</p>
                            @endif
                        </div>
                    @endforeach

                    <!-- نمایش تمام پاسخ‌ها (مخفی به‌صورت پیش‌فرض) -->
                    @if($comment->replies->count() > 1)
                        <div class="hidden-replies" id="hidden-replies-{{ $comment->id }}" style="display: none;">
                            @foreach($comment->replies->slice(1) as $reply) <!-- نمایش پاسخ‌های باقی‌مانده -->
                                <div class="reply" data-reply-id="{{ $reply->id }}">
                                    <div class="comment-header">
                                        <span class="comment-author">
                                            {{ $reply->user->name }}
                                            @if($reply->user->role === 'admin' || $reply->user->role === 'superadmin')
                                                <span class="admin-badge">مدیر</span>
                                            @endif
                                        </span>
                                        <span class="comment-date">{{ \Morilog\Jalali\Jalalian::fromDateTime($reply->created_at)->format('Y/m/d H:i') }}</span>
                                    </div>
                                    <p class="comment-body">{{ $reply->content }}</p>
                                    @if(auth()->check())
                                        <button class="reply-toggle-btn" data-comment-id="{{ $reply->id }}">پاسخ</button>
                                        <form action="{{ route('product.comment.reply', $comment->id) }}" method="POST" class="reply-form" id="reply-form-{{ $reply->id }}" style="display: none;">
                                            @csrf
                                            <input type="hidden" name="reply_to" value="{{ $reply->id }}">
                                            <div class="form-group">
                                                <textarea name="content" class="form-control" rows="3" required placeholder="پاسخ به {{ $reply->user->name }}..."></textarea>
                                            </div>
                                            <button type="submit" class="submit-reply-btn">ارسال پاسخ</button>
                                        </form>
                                    @else
                                        <p class="reply-login-message">برای پاسخ به این نظر، لطفاً <a href="{{ route('login') }}">وارد شوید</a>.</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <button class="show-all-replies-btn" data-comment-id="{{ $comment->id }}" data-reply-count="{{ $comment->replies->count() }}">
    مشاهده همه نظرات ({{ $comment->replies->count() }})
</button>
                    @endif
                </div>
            @endif
        </div>
    @empty
        <p>هنوز نظری برای این محصول ثبت نشده است.</p>
    @endforelse
</div>
        </div>
    </div>
</section>

@include('Home.layouts.footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // کد قبلی برای نمایش فرم پاسخ‌ها
    const replyButtons = document.querySelectorAll('.reply-toggle-btn');
    replyButtons.forEach(button => {
        button.addEventListener('click', function () {
            const commentId = this.getAttribute('data-comment-id');
            const form = document.getElementById(`reply-form-${commentId}`);
            const isVisible = form.style.display === 'block';

            // Hide all reply forms
            document.querySelectorAll('.reply-form').forEach(f => {
                f.style.display = 'none';
            });

            // Toggle the clicked form
            form.style.display = isVisible ? 'none' : 'block';
        });
    });

    // کد جدید برای نمایش همه پاسخ‌ها
    const showAllRepliesButtons = document.querySelectorAll('.show-all-replies-btn');
    showAllRepliesButtons.forEach(button => {
        button.addEventListener('click', function () {
            const commentId = this.getAttribute('data-comment-id');
            const hiddenReplies = document.getElementById(`hidden-replies-${commentId}`);
            const isVisible = hiddenReplies.style.display === 'block';

            hiddenReplies.style.display = isVisible ? 'none' : 'block';
            this.textContent = isVisible
                ? `مشاهده همه نظرات (${this.dataset.replyCount})`
                : 'مخفی کردن نظرات';
        });
    });
});
</script>

</body>
</html>
