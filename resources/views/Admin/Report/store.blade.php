@extends('Admin.layouts.master')

@section('content')
<section class="table-section" id="combined-report">
    <h2>گزارش موجودی محصولات و سفارشات</h2>

    <div class="add-item my-4">
     <form method="GET" class="row g-3">
        <div class="col-md-3">
            <label for="start_date" class="form-label">از تاریخ</label>
            <input type="text" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
        </div>
        <div class="col-md-3">
            <label for="end_date" class="form-label">تا تاریخ</label>
            <input type="text" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
        </div>
        <div class="col-md-3">
            <label for="product_name" class="form-label">جستجوی نام محصول در انبار</label>
            <input type="text" name="product_name" id="product_name" class="form-control" value="{{ request('product_name') }}">
        </div>
        <div class="col-md-3">
            <label for="order_id" class="form-label">کد سفارش</label>
            <input type="text" name="order_id" id="order_id" class="form-control" value="{{ request('order_id') }}">
        </div>
        @if(auth()->user()->role == 'super_admin')
<div class="row mb-4">
    <div class="col-md-12">
        <h4>فیلتر پیشرفته (سوپر ادمین)</h4>
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label for="store_id" class="form-label">مغازه</label>
                <select name="store_id" id="store_id" class="form-control">
                    <option value="">همه مغازه‌ها</option>
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}" {{ request('store_id') == $store->id ? 'selected' : '' }}>
                            {{ $store->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="category_id" class="form-label">دسته بندی</label>
                <select name="category_id" id="category_id" class="form-control">
                    <option value="">همه دسته‌ها</option>
                    @if(request('store_id'))
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">اعمال فیلتر</button>
            </div>
        </form>
    </div>
</div>
@endif



    </form>
    </div>

    {{-- نمایش گزارش موجودی محصولات فقط اگر کد سفارش وارد نشده باشد --}}
    @if(request('order_id') == null)
    <div class="report-section">
        <h3>گزارش موجودی محصولات</h3>
        @if($products->count())
            <span class="text-muted" style="font-size: 0.9rem;">(تعداد: {{ $products->count() }})</span>
        @endif
        <table class="table table-bordered text-center">
            <thead>
             <thead>
    <tr>
        <th>نام محصول</th>
        <th>نام مغازه</th>  {{-- ستون جدید --}}
        <th>موجودی فعلی</th>
        <th>تعداد فروخته‌شده</th>
        <th>تاریخ ثبت</th>
    </tr>
</thead>
<tbody>
    @forelse ($products as $product)
    <tr>
        <td>{{ $product->name }}</td>
        <td>{{ $product->store?->name ?? 'نامشخص' }}</td> {{-- نام مغازه --}}
        <td>{{ $product->inventory }}</td>
        <td>{{ $product->sold_quantity }}</td>
        <td>{{ $product->created_at ? jdate($product->created_at)->format('Y/m/d') : 'نامشخص' }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="5" class="text-center">هیچ محصولی یافت نشد</td>
    </tr>
    @endforelse
</tbody>

            </tbody>
        </table>
    </div>
    @endif

    {{-- نمایش گزارش سفارشات فقط اگر نام محصول وارد نشده باشد --}}
    @if(request('product_name') == null)
    <div class="report-section">
        <h3>گزارش سفارشات</h3>
        @if($orders->count())
            <span class="text-muted" style="font-size: 0.9rem;">(تعداد: {{ $orders->count() }})</span>
        @endif
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>کد سفارش</th>
                    <th>تعداد محصولات</th>
                    <th>مبلغ کل</th>
                    <th>تاریخ ثبت</th>
                    <th> عملیات</th>
                </tr>
            </thead>
            <tbody>
          @if($orders->count())
    @foreach($orders as $order)
        <tr>
            <td>سفارش #{{ $order->id }}</td>
            <td>{{ $order->orderItems->sum('quantity') }}</td>
            <td>
                {{ $order->orderItems->sum(function($item) use($user) {
                    if ($user->role == 'admin') {
                        return ($item->owner_store_id == $user->store_id)
                            ? $item->owner_share
                            : (($item->seller_store_id == $user->store_id) ? $item->seller_share : 0);
                    } else {
                        // سوپر ادمین و سایر نقش‌ها کل مبلغ را می‌بینند
                        return $item->owner_share + $item->seller_share;
                    }
                }) }} تومان
            </td>
            <td>{{ jdate($order->created_at)->format('Y/m/d') }}</td>
            <td>  <a href="{{ route('panel.report.show', $order->id) }}" class="btn btn-sm" style="color: #007bff;" title="جزئیات">
        <i class="fas fa-eye"></i>
    </a></td>
        </tr>
        <tr>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="4" class="text-center">هیچ سفارشی در این بازه ثبت نشده است</td>
    </tr>
@endif

            </tbody>
        </table>
    </div>
    @endif
</section>
<style>
    /* استایل کلی بخش */
.table-section {
    padding: 2rem 1.5rem;
    background-color: #f8f9fa;
    min-height: 100vh;
    direction: rtl;
}

.table-section h2 {
    font-family: 'Iranian Sans', sans-serif;
    font-size: 2rem;
    color: var(--primary-color);
    font-weight: bold;
    margin-bottom: 2rem;
    position: relative;
    padding-right: 1rem;
}

.table-section h2::before {
    content: '';
    position: absolute;
    right: 0;
    top: 50%;
    width: 5px;
    height: 60%;
    background: var(--accent-color);
    transform: translateY(-50%);
    border-radius: 5px;
}

/* استایل فرم جستجو */
.add-item {
    margin: 2rem 0;
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.add-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
}

.add-item .form-label {
    font-family: 'Iranian Sans', sans-serif;
    font-size: 0.95rem;
    color: var(--text-color);
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.add-item .form-control {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 0.75rem;
    font-family: 'Iranian Sans', sans-serif;
    font-size: 0.95rem;
    color: var(--text-color);
    background: #f9f9f9;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.add-item .form-control:focus {
    outline: none;
    border-color: var(--accent-color);
    box-shadow: 0 0 8px rgba(var(--accent-color-rgb), 0.3);
}

.add-item .form-control::placeholder {
    color: #999;
}

.add-item .btn-add {
    background: var(--accent-color);
    color: white;
    border: none;
    padding: 0.75rem;
    border-radius: 8px;
    font-family: 'Iranian Sans', sans-serif;
    font-size: 1rem;
    font-weight: bold;
    transition: background 0.3s ease, transform 0.2s ease;
    
}

.add-item .btn-add:hover {
    background: var(--secondary-color);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* استایل بخش گزارش */
.report-section {
    margin-bottom: 3rem;
}

.report-section h3 {
    font-family: 'Iranian Sans', sans-serif;
    font-size: 1.6rem;
    color: var(--primary-color);
    font-weight: bold;
    margin-bottom: 1rem;
}

.report-section .text-muted {
    font-family: 'Iranian Sans', sans-serif;
    font-size: 0.9rem;
    color: #6c757d;
}

/* استایل جدول */
.table {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    margin-bottom: 1.5rem;
}

.table thead {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
}

.table th {
    font-family: 'Iranian Sans', sans-serif;
    font-size: 1rem;
    font-weight: bold;
    padding: 1rem;
    text-align: center;
}

.table tbody tr {
    transition: background 0.3s ease;
}

.table tbody tr:hover {
    background: #f9f9f9;
}

.table td {
    font-family: 'Iranian Sans', sans-serif;
    font-size: 0.95rem;
    color: var(--text-color);
    padding: 1rem;
    vertical-align: middle;
}

.table td.text-center {
    text-align: center;
}

/* استایل دکمه جزئیات */
.table .btn-sm {

    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-family: 'Iranian Sans', sans-serif;
    font-size: 0.9rem;
    transition: background 0.3s ease, transform 0.2s ease;
}

.table .btn-sm:hover {

    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.table .btn-sm i {
    font-size: 1rem;
}

/* ریسپانسیو */
@media (max-width: 768px) {
    .table-section {
        padding: 1.5rem 1rem;
    }

    .table-section h2 {
        font-size: 1.6rem;
    }

    .add-item {
        padding: 1rem;
    }

    .add-item .form-control {
        font-size: 0.9rem;
        padding: 0.6rem;
    }

    .add-item .btn-add {
        font-size: 0.9rem;
        padding: 0.6rem;
    }

    .report-section h3 {
        font-size: 1.4rem;
    }

    .table th,
    .table td {
        font-size: 0.9rem;
        padding: 0.75rem;
    }

    .table .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
    }
}

@media (max-width: 480px) {
    .table-section h2 {
        font-size: 1.4rem;
    }

    .add-item .col-md-3 {
        flex: 0 0 100%;
        max-width: 100%;
    }

    .add-item .form-control,
    .add-item .btn-add {
        font-size: 0.85rem;
    }

    .table th,
    .table td {
        font-size: 0.85rem;
        padding: 0.6rem;
    }

    .table .btn-sm {
        padding: 0.3rem 0.6rem;
    }
}

</style>
@endsection
