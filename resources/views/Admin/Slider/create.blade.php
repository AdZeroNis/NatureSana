
@extends('Admin.layouts.master')

@section('content')
<section class="form-section" id="add-category">
    <h2>افزودن اسلایدر جدید</h2>
    <div class="card">
        <form method="POST" action="{{route('panel.slider.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">لینک اسلایدر </label>
                <input type="text" name="url" id="name" class="form-control" value="" required>
                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                    <label for="image">تصویر اسلایدر</label>
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    @error('image')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-submit">ذخیره اسلایدر</button>

            </div>
        </form>
    </div>
</section>
@endsection
