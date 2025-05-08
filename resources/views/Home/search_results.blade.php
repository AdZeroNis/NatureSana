<!DOCTYPE html>
<html lang="en">
    @include('Home.layouts.head')
<body>
    @include('Home.layouts.header')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-3">
                <!-- فیلترهای جستجو -->
                <!-- <div class="filter-card shadow-sm mb-4">
                <div class="filter-header">
                    <h5 class="mb-0">فیلترهای جستجو</h5>
                </div>
                <div class="card-body">
                    <form method="get" action="{{ route('search') }}">
                        <input type="hidden" name="search_key" value="{{ $searchKey }}">

                        <div class="form-group">
                            <label>نوع جستجو:</label>
                            <select name="search_type" class="form-control">
                                <option value="all" {{ $searchType === 'all' ? 'selected' : '' }}>همه موارد</option>
                                <option value="products" {{ $searchType === 'products' ? 'selected' : '' }}>محصولات</option>
                                <option value="categories" {{ $searchType === 'categories' ? 'selected' : '' }}>دسته‌بندی‌ها</option>
                                <option value="articles" {{ $searchType === 'articles' ? 'selected' : '' }}>مقالات</option>
                                <option value="stores" {{ $searchType === 'stores' ? 'selected' : '' }}>فروشگاه‌ها</option>
                            </select>
                        </div>

                        <button type="submit" class="filter-btn">اعمال فیلترها</button>
                    </form>
                </div>
                </div> -->
            </div>

            <div class="col-md-9">
                <h4 class="mb-4 search-title">نتایج جستجو برای: "{{ $searchKey }}"</h4>

                @if(isset($results['products']) && $results['products']->count())
                    <div class="result-section mb-4">
                        <div class="result-header products-header">
                            <h5 class="mb-0">محصولات</h5>
                        </div>
                        <div class="result-body">
                            <div class="product-grid">
                                @foreach($results['products'] as $product)
                                    @if ($product->status == 1)
                                        <div class="product-card">
                                            <!-- نشانگر محصول جدید -->
                                            @if($product->created_at->diffInDays() < 7)
                                                <div class="product-badge position-absolute top-0 start-0 m-2">
                                                    <span class="badge bg-danger py-2">جدید</span>
                                                </div>
                                            @endif

                                            <img src="{{ asset('AdminAssets/Product-image/' . $product->image) }}" alt="{{ $product->name }}">
                                            <h3>{{ Str::limit($product->name, 30) }}</h3>
                                            <p>{{ number_format($product->price) }} تومان</p>
                                            <!-- نام فروشگاه -->
                                            <div class="product-meta mb-2">
                                                <a href="{{ route('store.products', $product->store_id) }}" class="store-link text-decoration-none">
                                                    <small class="text-muted">{{ $product->store->name ?? 'نامشخص' }}</small>
                                                </a>
                                            </div>
                                            <form action="{{ route('product.show', $product->id) }}" method="GET">
                                                <button type="submit">مشاهده</button>
                                            </form>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @if(isset($results['categories']) && $results['categories']->count())
                    <div class="result-section mb-4">
                        <div class="result-header categories-header">
                            <h5 class="mb-0">دسته‌بندی‌ها</h5>
                        </div>
                        <div class="result-body">
                            <div class="list-group">
                                @foreach($results['categories'] as $category)
                                    <a href="{{ route('category.products', $category->id) }}" class="list-group-item">
                                        {{ $category->name }} ({{ $category->products_count }} محصول)
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @if(isset($results['articles']) && $results['articles']->count())
                    <div class="result-section mb-4">
                        <div class="result-header articles-header">
                            <h5 class="mb-0">مقالات</h5>
                        </div>
                        <div class="result-body">
                            @foreach($results['articles'] as $article)
                                <div class="article-item">
                                    <h5><a href="{{ route('article.show', $article->id) }}">{{ $article->title }}</a></h5>
                                    <p class="text-muted">{{ Str::limit(strip_tags($article->content), 100) }}</p>
                                    <small class="text-muted">تاریخ انتشار: {{ \Morilog\Jalali\Jalalian::fromDateTime($article->created_at)->format('Y/m/d') }}</small>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if(isset($results['stores']) && $results['stores']->count())
                    <div class="result-section mb-4">
                        <div class="result-header stores-header">
                            <h5 class="mb-0">فروشگاه‌ها</h5>
                        </div>
                        <div class="result-body">
                            <div class="row">
                                @foreach($results['stores'] as $store)
                                    <div class="col-md-6 mb-3">
                                        <div class="store-card">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('AdminAssets/Store-image/'.$store->image) }}" class="store-image" alt="{{ $store->name }}">
                                                <div class="store-info">
                                                    <h5 class="card-title mb-1">{{ $store->name }}</h5>
                                                    <p class="card-text text-muted mb-1">{{ $store->products_count }} محصول</p>
                                                    <a href="{{ route('store.products', $store->id) }}" class="result-btn">مشاهده فروشگاه</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @if((!isset($results['products']) || $results['products']->isEmpty()) &&
                   (!isset($results['categories']) || $results['categories']->isEmpty()) &&
                   (!isset($results['articles']) || $results['articles']->isEmpty()) &&
                   (!isset($results['stores']) || $results['stores']->isEmpty()))
                    <div class="no-results">
                        هیچ نتیجه‌ای برای جستجوی "{{ $searchKey }}" یافت نشد.
                    </div>
                @endif
            </div>
        </div>
    </div>
    @include('Home.layouts.footer')

</body>
</html>