@extends('layouts.app')

@section('content')
    <section class="banner inner-page">
        <div class="banner-img"><img src="{{ asset('images/banner/register-bannerImg.jpg') }}" alt=""></div>
        <div class="page-title">
            <div class="container">
                <h1 class="Tajawal-font">مراسلة الإدارة</h1>
            </div>
        </div>
    </section>
    <section class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="{{ route('home') }}">الرئيسية</a></li>
                <li><a href="{{ route('contact') }}">مراسلة الإدارة</a></li>
            </ul>
        </div>
    </section>
    <div class="container">
        @if(session('message'))
            <div class="alert alert-info">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <section class="contact-detail">
        <div class="container">
            <div class="contact-boxView">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="contact-box green">
                            <div class="icon-box">
                                <i class="fa fa-phone"></i>
                            </div>
                            <h4 class="Tajawal-font">رقم الهاتف</h4>
                            <p>{{ setting('site.phone') }}</p>
                            {{--<p>(02)121 321 322</p>--}}
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="contact-box red">
                            <div class="icon-box">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <h4 class="Tajawal-font">البريد الإلكتروني</h4>
                            <p><a href="mailTo:{{ setting('site.email') }}">{{ setting('site.email') }}</a></p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="contact-box yello">
                            <div class="icon-box">
                                <i class="fa fa-hand-o-down" aria-hidden="true"></i>
                            </div>
                            <h4 class="Tajawal-font">روابط التواصل الإجتماعي</h4>
                            <div class="contact-slide">
                                <a href="{{ setting('site.instagram', '#') }}"><i class="fa fa-instagram fontsize-30" aria-hidden="true"></i></a>
                                <a href="{{ setting('site.facebook', '#') }}"><i class="fa fa-facebook-square fontsize-30" aria-hidden="true"></i></a>
                                <a href="{{ setting('site.twitter', '#') }}"><i class="fa fa-twitter-square fontsize-30" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="contact-message">
        <div class="container">
            <div class="section-title">
                <h2 class="Tajawal-font">أرسل رسالة إلى إدارة الموقع</h2>
            </div>
            <div class="form-filde">
                <form action="{{ route('contact') }}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input-box">
                                <input type="text" class="form-control" placeholder="الإسم" data-validation="required" name="name">
                            </div>
                            <div class="input-box">
                                <input type="text" class="form-control" placeholder="رقم الهاتف" data-validation="required" name="phone">
                            </div>
                            <div class="input-box">
                                <select class="form-control" data-validation="required" name="subject">
                                    <option value="">سبب الإتصال</option>
                                    <option value="complaint">شكوى</option>
                                    <option value="suggestion">اقتراح</option>
                                    <option value="other">اخرى</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-box">
                                <textarea placeholder="محتوى الرسالة" class="form-control" data-validation="required" name="message"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="submit-box">
                                <input type="submit" value="إرسال" class="btn">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="contact-map" id="map">
    </section>
@endsection