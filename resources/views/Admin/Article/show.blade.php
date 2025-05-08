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
@endsection