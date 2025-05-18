@extends('Admin.layouts.master')

@section('content')
<section class="table-section" id="products">
    <div class="container">
        <div class="header">
            <h2>جزئیات همکاری فروشگاه‌ها</h2>
            <div class="actions">
                <a href="{{ route('panel.partner.index') }}" class="btn btn-back">
                    <i class="fas fa-arrow-left"></i> بازگشت به لیست
                </a>
            </div>
        </div>

        <div class="details-card">
            <div class="row">
                <div class="col-md-6">
                    <div class="detail-item">
                        <h4>فروشگاه اصلی:</h4>
                        <p>{{ $partner->store->name }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-item">
                        <h4>فروشگاه همکار:</h4>
                        <p>{{ $partner->partnerStore->name }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="detail-item">
                        <h4>وضعیت:</h4>
                        @if($partner->status == 0)
                            <span class="status-badge pending">در انتظار تایید</span>
                        @elseif($partner->status == 1)
                            <span class="status-badge active">تایید شده</span>
                        @else
                            <span class="status-badge inactive">رد شده</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-item">
                        <h4>تاریخ ایجاد:</h4>
                        <p>{{ \Morilog\Jalali\Jalalian::fromDateTime($partner->created_at)->format('Y/m/d H:i') }}</p>
                    </div>
                </div>
            </div>

            @if($partner->status == 1)
            <div class="products-section">
                @if($isSuperAdmin)
                    <h3>مدیریت محصولات هر دو فروشگاه</h3>

                    <div class="search-box mb-3">
                        <input type="text" id="superAdminProductSearch" class="form-control" placeholder="جستجوی محصول...">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h4>محصولات فروشگاه اصلی ({{ $partner->store->name }})</h4>
                            <form action="{{ route('panel.partner.products.store', $partner->id) }}" method="POST" id="mainStoreForm">
                                @csrf
                                <ul class="product-list" id="mainStoreProductsList">
                                    @foreach($mainStoreProducts as $index => $product)
                                        <li class="{{ $index >= 5 ? 'extra-product d-none' : '' }}">
                                            <label>
                                                <input type="checkbox" name="product_ids[]" value="{{ $product->id }}"
                                                    {{ in_array($product->id, $sharedProducts) ? 'checked' : '' }}>
                                                <span class="product-name">{{ $product->name }}</span> -
                                                <span>قیمت: {{ number_format($product->price) }} تومان</span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>

                                @if(count($mainStoreProducts) > 5)
                                    <button type="button" class="btn btn-secondary mt-2 show-all-btn" data-target="mainStoreProductsList">
                                        مشاهده همه محصولات
                                    </button>
                                @endif

                                <button type="submit" class="btn btn-primary mt-3">ذخیره تغییرات</button>
                            </form>
                        </div>

                        <div class="col-md-6">
                            <h4>محصولات فروشگاه همکار ({{ $partner->partnerStore->name }})</h4>
                            <form action="{{ route('panel.partner.products.store', $partner->id) }}" method="POST" id="partnerStoreForm">
                                @csrf
                                <ul class="product-list" id="partnerStoreProductsList">
                                    @foreach($partnerStoreProducts as $index => $product)
                                        <li class="{{ $index >= 5 ? 'extra-product d-none' : '' }}">
                                            <label>
                                                <input type="checkbox" name="product_ids[]" value="{{ $product->id }}"
                                                    {{ in_array($product->id, $sharedProducts) ? 'checked' : '' }}>
                                                <span class="product-name">{{ $product->name }}</span> -
                                                <span>قیمت: {{ number_format($product->price) }} تومان</span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>

                                @if(count($partnerStoreProducts) > 5)
                                    <button type="button" class="btn btn-secondary mt-2 show-all-btn" data-target="partnerStoreProductsList">
                                        مشاهده همه محصولات
                                    </button>
                                @endif

                                <button type="submit" class="btn btn-primary mt-3">ذخیره تغییرات</button>
                            </form>
                        </div>
                    </div>
                @else
                    <h3>
                        @if($isMainStore)
                            محصولات قابل نمایش از فروشگاه همکار
                        @elseif($isPartnerStore)
                            محصولات قابل نمایش از فروشگاه اصلی
                        @endif
                    </h3>

                    <div class="search-box mb-3">
                        <input type="text" id="productSearch" class="form-control" placeholder="جستجوی محصول...">
                    </div>

                    <form action="{{ route('panel.partner.products.store', $partner->id) }}" method="POST">
                        @csrf
                        <ul class="product-list" id="productList">
                            @foreach($productsToShow as $index => $product)
                                <li class="{{ $index >= 3 ? 'extra-product hidden-manual' : '' }}">
                                    <label>
                                        <input type="checkbox" name="product_ids[]" value="{{ $product->id }}"
                                            {{ in_array($product->id, $sharedProducts) ? 'checked' : '' }}>
                                        <span class="product-name">{{ $product->name }}</span> -
                                        <span>قیمت: {{ number_format($product->price) }} تومان</span> -
                                        <span>موجودی: {{ $product->inventory }}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>

                        @if(count($productsToShow) > 3)
                            <button type="button" id="showAllBtn" class="btn btn-secondary mt-2">مشاهده همه محصولات</button>
                        @endif

                        <button type="submit" class="btn btn-primary mt-3">
                            ذخیره محصولات انتخابی
                        </button>
                    </form>
                @endif
            </div>
            @endif
        </div>
    </div>
</section>

<style>
    .hidden-manual {
        display: none !important;
    }
</style>

<script>
    // فیلتر جستجو برای سوپر ادمین - فروشگاه اصلی و فروشگاه همکار
    document.getElementById("superAdminProductSearch")?.addEventListener("input", function () {
        const filter = this.value.toLowerCase();

        // لیست محصولات فروشگاه اصلی
        const mainStoreItems = document.querySelectorAll("#mainStoreProductsList li");
        mainStoreItems.forEach(function (item) {
            const productName = item.querySelector(".product-name").textContent.toLowerCase();
            if (productName.includes(filter)) {
                item.style.display = "";
            } else {
                item.style.display = "none";
            }
        });

        // لیست محصولات فروشگاه همکار
        const partnerStoreItems = document.querySelectorAll("#partnerStoreProductsList li");
        partnerStoreItems.forEach(function (item) {
            const productName = item.querySelector(".product-name").textContent.toLowerCase();
            if (productName.includes(filter)) {
                item.style.display = "";
            } else {
                item.style.display = "none";
            }
        });
    });

    // دکمه‌های نمایش همه محصولات برای سوپر ادمین
    document.querySelectorAll(".show-all-btn").forEach(function (btn) {
        btn.addEventListener("click", function () {
            const targetListId = btn.getAttribute("data-target");
            const productList = document.getElementById(targetListId);

            if (productList) {
                productList.querySelectorAll(".extra-product").forEach(function (item) {
                    item.classList.remove("d-none");
                });
            }

            btn.style.display = 'none';
        });
    });

    // جستجوی عادی برای کاربران غیر سوپر ادمین
    document.getElementById("productSearch")?.addEventListener("input", function () {
        const filter = this.value.toLowerCase();
        const items = document.querySelectorAll("#productList li");

        items.forEach(function (item) {
            const productName = item.querySelector(".product-name").textContent.toLowerCase();
            if (productName.includes(filter)) {
                item.style.display = "";
            } else {
                item.style.display = "none";
            }
        });
    });

    // دکمه نمایش همه محصولات برای کاربران غیر سوپر ادمین
    document.getElementById("showAllBtn")?.addEventListener("click", function (e) {
        e.preventDefault();
        document.querySelectorAll("#productList .extra-product").forEach(function (item) {
            item.classList.remove("hidden-manual");
        });
        this.style.display = 'none';
    });
</script>

@endsection
