@extends('Admin.layouts.master')

@section('title', 'جزئیات مقاله')

@section('content')
<section class="article-details">
    <div class="container">
        <div class="header">
            <h2>جزئیات مقاله</h2>
            <div class="actions">
                <a href="{{ route('panel.article.edit', $article->id) }}" class="btn btn-edit">
                    <i class="fas fa-edit"></i>
                    ویرایش
                </a>
                <a href="{{ route('panel.article.index') }}" class="btn btn-back">
                    <i class="fas fa-arrow-right"></i>
                    بازگشت
                </a>
            </div>
        </div>

        <div class="details-card">
            <div class="article-image">
                @if($article->image)
                    <img src="{{ asset('AdminAssets/Article-image/' . $article->image) }}" alt="{{ $article->title }}">
                @else
                    <div class="no-image">
                        <i class="fas fa-file-alt"></i>
                    </div>
                @endif
            </div>

            <div class="article-info">
                <div class="info-group">
                    <h3>اطلاعات اصلی</h3>
                    <div class="info-row">
                        <span class="label">عنوان مقاله:</span>
                        <span class="value">{{ $article->title }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">نویسنده:</span>
                        <span class="value">{{ $article->user ? $article->user->name : 'بدون نویسنده' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">تاریخ انتشار:</span>
                        <span class="value">{{ $article->published_at ? \Morilog\Jalali\Jalalian::fromDateTime($article->published_at)->format('Y/m/d H:i') : \Morilog\Jalali\Jalalian::fromDateTime($article->created_at)->format('Y/m/d H:i') }}</span>
                    </div>
                </div>

                <div class="info-group">
                    <h3>وضعیت</h3>
                    <div class="info-row">
                        <span class="label">وضعیت فعلی:</span>
                        <span class="value status-badge {{ $article->status == 1 ? 'active' : 'inactive' }}">
                            {{ $article->status == 1 ? 'فعال' : 'غیرفعال' }}
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="label">تاریخ ثبت:</span>
                        <span class="value">{{ \Morilog\Jalali\Jalalian::fromDateTime($article->created_at)->format('Y/m/d H:i') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">آخرین بروزرسانی:</span>
                        <span class="value">{{ \Morilog\Jalali\Jalalian::fromDateTime($article->updated_at)->format('Y/m/d H:i') }}</span>
                    </div>
                </div>

                <div class="info-group">
                    <h3>متن مقاله</h3>
                    <div class="article-content">
                        {!! $article->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.article-details {
    padding: 2rem;
    background-color: #f8f9fa;
    min-height: 100vh;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.header h2 {
    font-size: 1.8rem;
    color: var(--primary-color);
    margin: 0;
}

.actions {
    display: flex;
    gap: 1rem;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-size: 1rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn i {
    font-size: 1.1rem;
}

.btn-edit {
    background-color: var(--accent-color);
    color: white;
}

.btn-edit:hover {
    background-color: var(--secondary-color);
    transform: translateY(-2px);
}

.btn-back {
    background-color: #e9ecef;
    color: #495057;
}

.btn-back:hover {
    background-color: #dee2e6;
    transform: translateY(-2px);
}

.details-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    display: flex;
    gap: 2rem;
    padding: 2rem;
}

.article-image {
    flex: 0 0 300px;
    height: 300px;
    border-radius: 10px;
    overflow: hidden;
}

.article-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image {
    width: 100%;
    height: 100%;
    background-color: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
}

.no-image i {
    font-size: 4rem;
    color: #adb5bd;
}

.article-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.info-group {
    background-color: #f8f9fa;
    padding: 1.5rem;
    border-radius: 10px;
}

.info-group h3 {
    color: var(--primary-color);
    margin-bottom: 1rem;
    font-size: 1.2rem;
}

.info-row {
    display: flex;
    margin-bottom: 0.75rem;
    align-items: center;
}

.info-row:last-child {
    margin-bottom: 0;
}

.label {
    flex: 0 0 150px;
    color: #6c757d;
    font-weight: 500;
}

.value {
    color: #212529;
}

.status-badge {
    padding: 0.25rem 1rem;
    border-radius: 15px;
    font-size: 0.9rem;
}

.status-badge.active {
    background-color: #d4edda;
    color: #155724;
}

.status-badge.inactive {
    background-color: #f8d7da;
    color: #721c24;
}

.article-content {
    color: #212529;
    line-height: 1.6;
    font-family: 'Vazir', sans-serif;
    font-size: 1rem;
}

.article-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
}

.article-content p {
    margin-bottom: 1rem;
}

.article-content h1, .article-content h2, .article-content h3, .article-content h4, .article-content h5, .article-content h6 {
    margin-bottom: 0.75rem;
    color: #333;
}

.article-content ul, .article-content ol {
    margin-bottom: 1rem;
    padding-right: 1.5rem;
}

.article-content a {
    color: var(--primary-color);
    text-decoration: underline;
}

.article-content a:hover {
    color: var(--secondary-color);
}

@media (max-width: 768px) {
    .article-details {
        padding: 1rem;
    }

    .header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .details-card {
        flex-direction: column;
        padding: 1rem;
    }

    .article-image {
        flex: 0 0 200px;
        height: 200px;
    }

    .info-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }

    .label {
        flex: none;
    }
}
</style>
@endsection