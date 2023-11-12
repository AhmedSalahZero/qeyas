@extends('layouts.app')

@section('content')
    <style>
        .invalid-feedback {
            width: 100%;
            margin-top: .25rem;
            font-size: 120%;
            color: #e3342f
        }

        .is-invalid {
            border-color: #e3342f !important;
        }
    </style>
    <section class="banner inner-page">
        <div class="banner-img">
            <img src="{{ asset('images/banner/register-bannerImg.jpg') }}" alt="">
        </div>
        <div class="page-title">
            <div class="container">
                <h1 class="Tajawal-font">تعديل حسابي</h1>
            </div>
        </div>
    </section>
    <section class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="{{ route('home') }}">الرئيسية</a></li>
                <li><a href="{{ route('user.profile') }}">حسابي</a></li>
                <li><a href="{{ route('user.edit-profile') }}">تعديل حسابي</a></li>
            </ul>
        </div>
    </section>
    <section class="login-view">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="section-title">
                        <h2 class="Tajawal-font">تعديل حسابي</h2>
                        <p>يمكنك تعديل بيانات حسابك من هنا</p>
                    </div>
                    <form action="{{ route('user.update-profile') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="editAccount editAcoount-box text-center">
                            <img id="thumb_id_preview"
                                 src="@if(filter_var($user->avatar, FILTER_VALIDATE_URL)) {{ $user->avatar }} @else {{ Voyager::image($user->avatar, asset('images/blog/post-img1.jpg')) }}@endif"
                                 alt="Personal Image"
                                 class="editprofile-img">
                            <div class="editprofile-button">
                                <label class="btn btn-default">
                                    <i class="fa fa-camera" aria-hidden="true"></i>
                                    <input type="file" name="user_photo" id="member_thumb_id" style="display: none;">
                                </label>
                            </div>
                            @if ($errors->has('user_photo'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('user_photo') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="input-box">
                            <label for="name">الاسم</label>
                            <input type="text"
                                   id="name" name="name"
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                   value="{{ $user->name }}"
                                   placeholder="الإسم">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="input-box">
                            <label for="email">البريد الالكتروني</label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                   value="{{ $user->email }}"
                                   placeholder="البريد الالكتروني">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="input-box">
                            <label for="phone">الهاتف</label>
                            <input type="number"
                                   name="phone"
                                   id="phone"
                                   class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                   value="{{ $user->phone }}"
                                   placeholder="رقم الهاتف">
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="input-box">
                            <label for="gender">النوع</label>
                            <select name="gender" id="gender" class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}">
                                <option value="">الجنس</option>
                                <option value="m" {{ $user->gender === 'm' ? 'selected' : '' }} >ذكر</option>
                                <option value="f" {{ $user->gender === 'f' ? 'selected' : '' }} >أنثى</option>
                            </select>
                            @if ($errors->has('gender'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('gender') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="input-box">
                            @php($educations = App\Education::all())
                            <label for="education">المرحلة الدراسية</label>
                            <select name="education" id="education" class="form-control{{ $errors->has('education') ? ' is-invalid' : '' }}">
                                <option value="">المرحلة الدراسية</option>
                                @foreach($educations as $education)
                                    <option value="{{ $education->id }}" {{ $user->education_level == $education->id ? 'selected' : (old('education') == $education->id ? 'selected' : '') }}>{{ $education->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('education'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('education') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="input-box">
                            <label for="city">المدينة</label>
                            @php($cities = App\City::all())
                            <select name="city" id="city" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}">
                                <option value="">المدينة</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ $user->city === $city->id ? 'selected' : (old('city') == $city->id ? 'selected' : '') }}>{{ $city->city_name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('city'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="submit-slide">
                            <input type="submit" value="حفظ" class="btn">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection