@extends('Admin.layouts.master')
 @section('content')
 <section class="table-section" id="products">
    <h2>مدیریت محصولات</h2>
    <div class="add-item">
        <button>افزودن محصول جدید</button>
    </div>
    <table>
        <thead>
            <tr>
                <th>شناسه</th>
                <th>نام</th>
                <th>دسته‌بندی</th>
                <th>قیمت</th>
                <th>موجودی</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>۰۰۱</td>
                <td>اکیناسه</td>
                <td>گیاهان دارویی</td>
                <td>۱۹.۹۹ دلار</td>
                <td>۱۰۰</td>
                <td class="action-buttons">
                    <button>ویرایش</button>
                    <button>حذف</button>
                </td>
            </tr>
            <tr>
                <td>۰۰۲</td>
                <td>ریشه زنجبیل</td>
                <td>ریشه‌ها</td>
                <td>۱۴.۹۹ دلار</td>
                <td>۸۰</td>
                <td class="action-buttons">
                    <button>ویرایش</button>
                    <button>حذف</button>
                </td>
            </tr>
            <tr>
                <td>۰۰۳</td>
                <td>آشواگاندا</td>
                <td>مکمل‌ها</td>
                <td>۲۴.۹۹ دلار</td>
                <td>۵۰</td>
                <td class="action-buttons">
                    <button>ویرایش</button>
                    <button>حذف</button>
                </td>
            </tr>
        </tbody>
    </table>
</section>
 @endsection
