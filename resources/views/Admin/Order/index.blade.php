@extends('Admin.layouts.master')

@section('content')

<section class="table-section" id="products">
    <h2>مدیریت  سفارشات</h2>

    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>شناسه</th>
                <th>نام</th>
                <th>فروشگاه</th>
                <th> تایخ ثبت</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
    @foreach($orders as $order)
<tr>
    <td>{{ $order->id }}</td>

    <td>
        @foreach($order->orderItems as $item)
            {{ $item->product->name }} <br>
        @endforeach
    </td>

    <td>
        @foreach($order->orderItems as $item)
            {{ $item->product->store->name ?? 'ندارد' }} <br>
        @endforeach
    </td>

    <td>{{ \Morilog\Jalali\Jalalian::fromDateTime($order->created_at)->format('Y/m/d H:i') }}</td>

 <td class="action-buttons">
    {{-- اگر اجازه ویرایش هست، دراپ‌داون نمایش بده --}}
   @if($order->can_edit)

        <form action="{{ route('panel.order.updateStatus', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
    <select name="status" class="status-dropdown" onchange="this.form.submit()">
    <option value="0" {{ $order->status == 0 ? 'selected' : '' }}>درحال پردازش</option>
    <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>ارسال</option>
    <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>عدم ارسال</option>
</select>
        </form>
    @else
        {{-- فقط نمایش وضعیت (بدون امکان تغییر) --}}
        @if($order->status == 0)
            درحال پردازش
        @elseif($order->status == 1)
            ارسال
        @else
            عدم ارسال
        @endif
    @endif
        <a href="#"
           class="btn btn-sm"
           style="color: red;"
           title="حذف"
           onclick="event.preventDefault(); if(confirm('آیا از حذف این سفارش مطمئن هستید؟')) {
               document.getElementById('delete-form-{{ $order->id }}').submit(); }">
            <i class="fas fa-trash-alt"></i>
        </a>

        <form id="delete-form-{{ $order->id }}" action="{{ route('panel.order.delete', $order->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
            <a href="{{ route('panel.order.show', $order->id) }}" class="btn btn-sm" style="color: #007bff;" title="جزئیات">
        <i class="fas fa-eye"></i>
    </a>
</td>

</tr>
@endforeach

        </tbody>
    </table>
</section>


@endsection
