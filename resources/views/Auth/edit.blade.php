@extends('Auth.layouts.master')

@section('content')
    <div class="container py-5 "style="margin-left: 10rem !important">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

      <div class="profile-section">
        <!-- هدر -->
        <div class="profile-header">
          <h2>✏️ ویرایش پروفایل</h2>
        </div>

        <!-- استفاده از flexbox برای کنار هم قرار دادن فرم‌ها -->
        <div class="d-flex justify-content-between secOne">
          <!-- فرم ویرایش پروفایل -->

       
          <!-- فرم تغییر رمز عبور -->
          <div class="edit-profile-form" style="flex: 1; margin-left: 1rem">
            <h4>🔒 تغییر رمز عبور</h4>
            <form action="{{ route('update.password', auth()->user()->id)}}" method="POST">
              @csrf

              <div class="form-group">
                <label for="current_password">رمز فعلی</label>
                <input
                  type="password"
                  name="current_password"
                  id="current_password"
                  class="form-control"
                  required
                />
              </div>

              <div class="form-group">
                <label for="new_password">رمز جدید</label>
                <input
                  type="password"
                  name="new_password"
                  id="new_password"
                  class="form-control"
                  required
                />
              </div>

              <div class="form-group">
                <label for="new_password_confirmation">تکرار رمز جدید</label>
                <input
                  type="password"
                  name="new_password_confirmation"
                  id="new_password_confirmation"
                  class="form-control"
                  required
                />
              </div>

              <button type="submit" class="save-btn">
                🔐 بروزرسانی رمز عبور
              </button>
            </form>
          </div>
          <div class="edit-profile-form" style="flex: 1; margin-right: 1rem">
            <form
              action="{{ route('edit.profile.submit', auth()->user()->id) }}"
              method="POST"
              enctype="multipart/form-data"
            >
              @csrf

              <div class="form-group">
                <label for="name">نام</label>
                <input
                  type="text"
                  name="name"
                  id="name"
                  class="form-control"
                  value="{{ auth()->user()->name }}"
                  required
                />
              </div>

              <div class="form-group">
                <label for="email">ایمیل</label>
                <input
                  type="email"
                  name="email"
                  id="email"
                  class="form-control"
                  value="{{ auth()->user()->email }}"
                  required
                />
              </div>

              <div class="form-group">
                <label for="phone">تلفن</label>
                <input
                  type="text"
                  name="phone"
                  id="phone"
                  class="form-control"
                  value="{{ auth()->user()->phone }}"
                  required
                />
              </div>

              <div class="form-group">
                <label for="address_one">آدرس 1</label>
                <input
                  type="text"
                  name="address_one"
                  id="address_one"
                  class="form-control"
                  value="{{ auth()->user()->address->address_one ?? '' }}"
                  placeholder="آدرس شامل کد پستی و آدرس محل مورد نظر باشد"
                />
              </div>
              <div class="form-group">
                <label for="address_two">آدرس 2</label>
                <input
                  type="text"
                  name="address_two"
                  id="address_two"
                  class="form-control"
                  value="{{ auth()->user()->address->address_two ?? '' }}"
                  placeholder="آدرس شامل کد پستی و آدرس محل مورد نظر باشد"
                />
              </div>
              <div class="form-group">
                <label for="address_three">آدرس 3</label>
                <input
                  type="text"
                  name="address_three"
                  id="address_three"
                  class="form-control"
                  value="{{ auth()->user()->address->address_three ?? '' }}"
                  placeholder="آدرس شامل کد پستی و آدرس محل مورد نظر باشد"
                />
              </div>


<button type="submit" class="save-btn">💾 ذخیره تغییرات</button>
            </form>
          </div>

        </div>
      </div>
    </div>

@endsection
