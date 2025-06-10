<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>فاکتور سفارش</title>
    <style>
        body {
            font-family: 'Tahoma', 'Vazir', sans-serif;
            direction: rtl;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .invoice-section {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .invoice-header h1 {
            font-size: 28px;
            color: #333;
            margin: 0;
        }
        .invoice-header p {
            font-size: 14px;
            color: #666;
            margin: 5px 0;
        }
        .invoice-title {
            font-size: 22px;
            color: #007bff;
            margin-bottom: 20px;
            text-align: right;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: right;
        }
        .table th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }
        .table td {
            background-color: #fff;
        }
        .table tfoot th {
            background-color: #f8f9fa;
            font-size: 16px;
        }
        .btn-print {
            display: block;
            margin: 30px auto 0;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-print:hover {
            background-color: #0056b3;
        }
        @media print {
            .btn-print {
                display: none;
            }
            .invoice-section {
                box-shadow: none;
                border: none;
            }
            body {
                background-color: #fff;
            }
        }
    </style>
</head>
<body>
    <section class="invoice-section">
        <div class="invoice-header">
            <h1>NatureSana</h1>
            <p>فاکتور رسمی خرید</p>
            <p>تماس:09336892362| ایمیل: shaghayeghk2001@gmail.com</p>
        </div>
        <h2 class="invoice-title">فاکتور سفارش شماره #{{ $order->id }}</h2>
        <p>تاریخ ثبت: {{ jdate($order->created_at)->format('Y/m/d') }}</p>

        <table class="table">
            <thead>
                <tr>
                    <th>نام محصول</th>
                    <th>تعداد</th>
                    <th>فروشگاه مالک</th>
                    <th>فروشگاه فروشنده</th>
                    <th>سهم مالک (تومان)</th>
                    <th>سهم فروشنده (تومان)</th>
                    <th>جمع سهم‌ها (تومان)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                    @if($user->role == 'admin')
                        @if($item->owner_store_id == $user->store_id || $item->seller_store_id == $user->store_id)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->ownerStore?->name ?? 'نامشخص' }}</td>
                                <td>{{ $item->sellerStore?->name ?? 'ندارد' }}</td>
                                <td>{{ number_format($item->owner_share) }}</td>
                                <td>{{ number_format($item->seller_share) }}</td>
                                <td>{{ number_format($item->owner_share + $item->seller_share) }}</td>
                            </tr>
                        @endif
                    @else
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->ownerStore?->name ?? 'نامشخص' }}</td>
                            <td>{{ $item->sellerStore?->name ?? 'ندارد' }}</td>
                            <td>{{ number_format($item->owner_share) }}</td>
                            <td>{{ number_format($item->seller_share) }}</td>
                            <td>{{ number_format($item->owner_share + $item->seller_share) }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="6" style="text-align: left;">مبلغ کل</th>
                    <th>
                        {{ number_format($order->orderItems->sum(function($item) use($user) {
                            if ($user->role == 'admin') {
                                return ($item->owner_store_id == $user->store_id)
                                    ? $item->owner_share
                                    : (($item->seller_store_id == $user->store_id) ? $item->seller_share : 0);
                            } else {
                                return $item->owner_share + $item->seller_share;
                            }
                        })) }} تومان
                    </th>
                </tr>
            </tfoot>
        </table>

        <button onclick="window.print()" class="btn-print">چاپ فاکتور</button>
    </section>
</body>
</html>
