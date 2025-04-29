@extends('Admin.layouts.master')

@section('content')
<section class="form-section" id="edit-user">
    <h2>ویرایش کاربر</h2>
    <div class="card">
        <form method="POST" action="{{route('panel.user.update', $user->id)}}">
            @csrf
            <div class="form-group">
                <label for="status" class="d-block">وضعیت</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>فعال</option>
                    <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>غیرفعال</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-submit">ویرایش کاربر</button>
            </div>
        </form>
    </div>
</section>
@endsection
