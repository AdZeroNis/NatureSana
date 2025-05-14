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

            @if($partner->status == 0)
                <div class="approval-actions">
                    @if(auth()->user()->store_id == $partner->store_id && is_null($partner->store_approval))
                        <form action="{{ route('panel.partner.update', $partner->id) }}" method="POST" class="d-inline">
                            @csrf
                          
                            <button type="submit" name="status" value="1" class="btn btn-success">
                                <i class="fas fa-check"></i> تایید فروشگاه اصلی
                            </button>
                        </form>
                        <form action="{{ route('panel.partner.update', $partner->id) }}" method="POST" class="d-inline">
                            @csrf
                         
                            <button type="submit" name="status" value="2" class="btn btn-danger">
                                <i class="fas fa-times"></i> رد فروشگاه اصلی
                            </button>
                        </form>
                    @endif

                    @if(auth()->user()->store_id == $partner->partner_store_id && is_null($partner->partner_approval))
                        <form action="{{ route('panel.partner.update', $partner->id) }}" method="POST" class="d-inline">
                            @csrf
                         
                            <button type="submit" name="status" value="1" class="btn btn-success">
                                <i class="fas fa-check"></i> تایید فروشگاه همکار
                            </button>
                        </form>
                        <form action="{{ route('panel.partner.update', $partner->id) }}" method="POST" class="d-inline">
                            @csrf
                            
                            <button type="submit" name="status" value="2" class="btn btn-danger">
                                <i class="fas fa-times"></i> رد فروشگاه همکار
                            </button>
                        </form>
                    @endif
                </div>
            @endif

            <div class="products-section">
                <h3>محصولات منحصر به فرد فروشگاه اصلی</h3>
                @if($uniqueStoreProducts->count() > 0)
                    <ul class="product-list">
                        @foreach($uniqueStoreProducts as $product)
                            <li>{{ $product->name }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>هیچ محصول منحصر به فردی برای فروشگاه اصلی وجود ندارد.</p>
                @endif

                <h3>محصولات منحصر به فرد فروشگاه همکار</h3>
                @if($uniquePartnerProducts->count() > 0)
                    <ul class="product-list">
                        @foreach($uniquePartnerProducts as $product)
                            <li>{{ $product->name }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>هیچ محصول منحصر به فردی برای فروشگاه همکار وجود ندارد.</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection