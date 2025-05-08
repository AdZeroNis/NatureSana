
<!DOCTYPE html>
<html lang="en">
    @include('Home.layouts.head')
<body>
    @include('Home.layouts.header')
<section class="shop-section" id="shop">
    <h2>مقالات</h2>
    <div class="product-grid">
        @foreach ($latestArticles as $article)
            <div class="product-card">
                <img src="{{ asset('AdminAssets/Article-image/' . $article->image) }}" alt="{{ $article->title }}">
                <h3>{{ $article->title }}</h3>
                <p>نویسنده: {{ $article->user->name }}</p>
                <form action="{{ route('article.show', $article->id) }}" method="GET">
                    <button type="submit"> مشاهده </button>
                </form>
            </div>
        @endforeach
    </div>
</section>

@include('Home.layouts.footer')

</body>
</html>