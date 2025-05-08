

<!DOCTYPE html>
<html lang="en">
    @include('Home.layouts.head')
<body>
    @include('Home.layouts.header')
<section class="single-article-section">
    <div class="container">
        <div class="article-header">
            <h1>{{ $article->title }}</h1>
        </div>

        <div class="article-image">
            @if($article->image)
                <img src="{{ asset('AdminAssets/Article-image/' . $article->image) }}" alt="{{ $article->title }}">
            @else
                <div class="no-image">
                    <i class="fas fa-file-alt"></i>
                </div>
            @endif
        </div>
        <div class="article-meta">
                <span><i class="fas fa-user"></i> نویسنده: {{  $article->user->name}}</span>
                <span><i class="fas fa-calendar-alt"></i> {{ $article->published_at ? \Morilog\Jalali\Jalalian::fromDateTime($article->published_at)->format('Y/m/d') : \Morilog\Jalali\Jalalian::fromDateTime($article->created_at)->format('Y/m/d') }}</span>
                
            </div>
        <div class="article-content">
            {!! $article->content !!}
        </div>

  
    </div>
</section>

@include('Home.layouts.footer')
</body>
</html>