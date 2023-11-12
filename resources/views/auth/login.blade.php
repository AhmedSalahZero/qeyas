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
        <div class="banner-img"><img src="{{ asset('images/banner/register-bannerImg.jpg') }}" alt=""></div>
        <div class="page-title">
            <div class="container">
                <h1 class="Tajawal-font">دخول</h1>
            </div>
        </div>
    </section>
    <section class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="{{ route('home') }}">الرئيسية</a></li>
                <li><a href="{{ route('login') }}">دخول & إنشاء حساب</a></li>
            </ul>
        </div>
    </section>
    <section class="login-view">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="section-title">
                        <h2 class="Tajawal-font">دخول</h2>
                        <p>قم بإدخال حسابك</p>
                    </div>
                    <form action="{{ route('login') }}" method="post">
                        {{ csrf_field() }}
                        <div class="input-box">
                            <input type="number" name="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="رقم الهاتف">
                        </div>
                        <div class="input-box">
                            <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="كلمة المرور">
                        </div>
                        @if ($errors->has('phone'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                        <div class="check-slide">
                            <label class="label_check" for="checkbox-01">
                                <input id="checkbox-01" name="remember" type="checkbox">تذكرني
                            </label>
                            <div class="right-link">
                                <a href="#">نسيت كلمة المرور؟ </a>
                            </div>
                        </div>
                        <div class="submit-slide">
                            <input type="submit" value="دخول" class="btn">
                        </div>
                    </form>
                </div>
                <div class="col-sm-6">
                    <div class="section-title">
                        <h2 class="Tajawal-font">إنشاء حساب</h2>
                        <p>أنشئ حسابك الآن - حساب مجاني</p>
                    </div>
                    <form action="{{ route('register') }}" method="post">
                        {{ csrf_field() }}
                        <div class="input-box">
                            <input type="text"
                                   name="name"
                                   placeholder="الإسم"
                                   value="{{ old('name') }}"
                                   class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="input-box">
                            <input type="number"
                                   name="r_phone"
                                   placeholder="رقم الهاتف"
                                   value="{{ old('r_phone') }}"
                                   class="form-control {{ $errors->has('r_phone') ? ' is-invalid' : '' }}">
                            @if ($errors->has('r_phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('r_phone') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="input-box">
                            <input type="email"
                                   name="email"
                                   placeholder="البريد الالكتروني"
                                   value="{{ old('email') }}"
                                   class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="input-box">
                            <select class="form-control" name="gender">
                                <option value="">الجنس</option>
                                <option value="m">ذكر</option>
                                <option value="f">أنثى</option>
                            </select>
                            @if ($errors->has('gender'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="input-box">
                            @php($educations = \App\Education::all())
                            <select name="education" class="form-control">
                                <option>المرحلة الدراسية</option>
                                @foreach($educations as $education)
                                    <option value="{{ $education->id }}">{{ $education->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('education'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('education') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="input-box">
                            @php($cities = App\City::all())
                            <select name="city" class="form-control">
                                <option>المدينة</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('city'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="input-box">
                            <input type="password"
                                   name="r_password"
                                   placeholder="كلمة المرور"
                                   class="form-control {{ $errors->has('r_password') ? ' is-invalid' : '' }}">
                            @if ($errors->has('r_password'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('r_password') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="input-box">
                            <input type="password"
                                   name="r_password_confirmation"
                                   placeholder="تاكيد كلمة المرور"
                                   class="form-control {{ $errors->has('r_password_confirmation') ? ' is-invalid' : '' }}">
                            @if ($errors->has('r_password_confirmation'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('r_password_confirmation') }}</strong>
                                    </span>
                            @endif
                        </div>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        <div class="submit-slide">
                            <input type="submit" value="إنشاء حساب" class="btn btn-outline-info">
                        </div>
                    </form>
                </div>
            </div>
            <div class="sosiyal-login">
                <div class="row">
                    <div class="col-sm-4 col-md-4">
                        <a target="_blank" href="{{ route('social_login', 'facebook') }}" class="facebook">
                            <i class="fa fa-facebook"></i>Facebook
                        </a>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <a target="_blank" href="{{ route('social_login', 'twitter') }}" class="twitter">
                            <i class="fa fa-twitter"></i>Twitter
                        </a>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <a target="_blank" href="{{ route('social_login', 'snapchat') }}" class="linkedin">
                            <i class="fa fa-snapchat-ghost"></i>Snapchat
                        </a>
                    </div>
                    @if(session('failed'))
                        <div class="alert alert-danger">
                            {{ session('failed') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection