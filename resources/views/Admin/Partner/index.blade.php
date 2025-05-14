@extends('Admin.layouts.master')

@section('content')
<section class="table-section" id="products">
    <h2>مدیریت همکاری فروشگاه‌ها</h2>

    <div class="add-item my-3">
        <a href="{{ route('panel.partner.create') }}" class="btn btn-add">افزودن همکاری جدید</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>شناسه</th>
                <th>فروشگاه اصلی</th>
                <th>فروشگاه همکار</th>
                <th>وضعیت</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($partners as $partner)
            <tr>
                <td>{{ $partner->id }}</td>
                <td>{{ $partner->store->name }}</td>
                <td>{{ $partner->partnerStore->name }}</td>
        <td class="text-center">
    @if($partner->status == 0)
        <span class="badge badge-warning">در انتظار تایید</span>
    @elseif($partner->status == 1)
        <span class="badge badge-success">تایید شده</span>
    @else
        <span class="badge badge-danger">رد شده</span>
    @endif
    <br>
  
</td>

                <td class="action-buttons">
                <a href="{{ route('panel.partner.show', $partner->id) }}" class="btn btn-sm" style="color: #007bff;" title="جزئیات">
        <i class="fas fa-eye"></i>
    </a>
                @if($partner->status == 0)
    @if(auth()->user()->store_id == $partner->store_id && is_null($partner->store_approval))
        {{-- دکمه‌های فروشگاه اصلی --}}
        <form action="{{ route('panel.partner.update', $partner->id) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" name="status" value="1" class="btn btn-sm btn-success" title="تایید فروشگاه اصلی">
                <i class="fas fa-check"></i>
            </button>
        </form>
        <form action="{{ route('panel.partner.update', $partner->id) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" name="status" value="2" class="btn btn-sm btn-danger" title="رد فروشگاه اصلی">
                <i class="fas fa-times"></i>
            </button>
        </form>
    @endif
    @if(auth()->user()->store_id == $partner->partner_store_id && is_null($partner->partner_approval))
        {{-- دکمه‌های فروشگاه همکار --}}
        <form action="{{ route('panel.partner.update', $partner->id) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" name="status" value="1" class="btn btn-sm btn-success" title="تایید فروشگاه همکار">
                <i class="fas fa-check"></i>
            </button>
        </form>
        <form action="{{ route('panel.partner.update', $partner->id) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" name="status" value="2" class="btn btn-sm btn-danger" title="رد فروشگاه همکار">
                <i class="fas fa-times"></i>
            </button>
        </form>
    @endif
@endif
                    
                    @if(auth()->user()->role === 'super_admin' || 
                        auth()->user()->store_id === $partner->store_id || 
                        auth()->user()->store_id === $partner->partner_store_id)

                        <form action="{{ route('panel.partner.delete', $partner->id) }}" method="POST" style="display: inline;" 
                              onsubmit="return confirm('آیا از حذف این همکاری مطمئن هستید؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="حذف همکاری">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">هیچ همکاری‌ای ثبت نشده است</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</section>
@endsection
