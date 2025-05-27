@extends('Admin.layouts.master')

@section('content')
<section class="table-section" id="products">
    <h2>مدیریت سبد خرید</h2>
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
            @forelse($carts as $cart)
            <tr>
                <td>{{ $cart->id }}</td>
                <td>{{ $cart->product->name }}</td>
                <td>{{ $cart->product->store->name ?? 'ندارد' }}</td>
                <td>{{ \Morilog\Jalali\Jalalian::fromDateTime($cart->created_at)->format('Y/m/d H:i') }}</td>
            <td class="action-buttons">
    <a href="{{ route('panel.cart.show', $cart->id) }}" class="btn btn-sm" style="color: #007bff;" title="جزئیات">
        <i class="fas fa-eye"></i>
    </a>

    <a href="#"
       class="btn btn-sm"
       style="color: red;"
       title="حذف"
           onclick="event.preventDefault(); if(confirm('آیا از حذف این سبد خرید مطمئن هستید؟')) {
               document.getElementById('delete-form-{{ $cart->id }}').submit(); }">
            <i class="fas fa-trash-alt"></i>
        </a>

        <form id="delete-form-{{ $cart->id }}" action="{{ route('panel.cart.delete', $cart->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    
</td>

            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">هیچ سبد خریدی یافت نشد</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</section>


@endsection
