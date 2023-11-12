@extends('layouts.app')

@section('content')
    <section class="banner inner-page">
        <div class="banner-img"><img src="images/banner/register-bannerImg.jpg" alt=""></div>
        <div class="page-title">
            <div class="container">
                <h1 class="Tajawal-font">عن قياس2030</h1>
            </div>
        </div>
    </section>
    <section class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="{{ route('home') }}">الرئيسية</a></li>
                <li><a href="{{ route('about') }}">عن قياس2030</a></li>
            </ul>
        </div>
    </section>
    <section class="about-page">
        <section class="about-target-audience">
            <div class="container">
                <div class="section-title">
                    <h2 class="Tajawal-font">قياس2030</h2>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        {!! setting('site.about_qeyas', '<p>هذا النص هو مثال لنص يمكن أن يستبدل في نفس
                           المساحة، لقد تم توليد هذا النص من مولد النص العربى،
                           حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص
                           الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.
                           إذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص
                           العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما
                           ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي
                           المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من
                           الأحيان أن يطلع على صورة حقيقية لتصميم الموقع</p>
                        <p>هذا النص هو مثال لنص يمكن أن يستبدل في نفس
                           المساحة، لقد تم توليد هذا النص من مولد النص العربى،
                           حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص
                           الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.
                           إذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص
                           العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما
                           ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي
                           المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من
                           الأحيان أن يطلع على صورة حقيقية لتصميم الموقع </p>') !!}
                    </div>
                    <div class="col-sm-6 text-center">
                        <img src="{{ asset('images/about-img1.png') }}" alt="">
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection