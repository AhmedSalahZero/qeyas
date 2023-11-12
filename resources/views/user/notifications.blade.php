@extends('layouts.app')

@section('content')
    <section class="banner inner-page">
        <div class="banner-img"><img src="{{ asset('images/banner/register-bannerImg.jpg') }}" alt=""></div>
        <div class="page-title">
            <div class="container">
                <h1 class="Tajawal-font">الإشعارات</h1>
            </div>
        </div>
    </section>
    <section class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="{{ route('home') }}">الرئيسية</a></li>
                <li><a href="{{ route('user.notifications') }}">الإشعارات</a></li>
            </ul>
        </div>
    </section>
    <section class="notification-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @foreach($notifications as $notification)
                        <div class="nTf-body">
                            <p class="fontsize-18">{{ $notification->content }}</p>
                            <span class="fontsize-16">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection