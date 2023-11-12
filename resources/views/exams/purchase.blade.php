@extends('layouts.app')

@section('content')
<style>
.tabcontent{
	position:absolute;
	top:60%;
	width:100%;
}
    .tabcontent {
        height: auto !important;
    }
	.product-bg{
  text-align: center;
  margin: auto;
    margin-top: auto;
    margin-bottom: auto;
  background: #e6e6e6;
  padding: 35px;
  margin-bottom: 20px;
  margin-top: 20px;
}
.iframBody{
		width:100% !important;
	}
</style>
<section class="banner inner-page">
    <div class="banner-img"><img src="{{ asset('images/banner/register-bannerImg.jpg') }}" alt=""></div>
    <div class="page-title">
        <div class="container">
            <h1 class="Tajawal-font">اتمام عمليه دفع
                <br>
                {{ $product->getName() }}
            </h1>
        </div>
    </div>
</section>
<section class="breadcrumb">
    <div class="container">
        <ul>
            <li><a href="{{ route('home') }}">الرئيسية</a></li>
            <li>
                اتمام الدفع
                [
                {{ $product->getName() }}
                ]
            </li>
        </ul>
    </div>
</section>
<section class="courses-view list-view">
    <div class="container">
        <div class="row">
           <div style="height:1500px;"></div>
            <div id="visa" class="tabcontent">
				<div class="product-bg">
				<h3 style="margin-bottom:20px;">
								الاسم:
								{{ $product->getName() }}
								</h3>
								
									@if($modelName == 'Book')
								<h3 style="margin-bottom:20px;">
								<span>
								عدد النسخ:
								</span>
								{{ $quantity }}
								</h3>
								@endif 
								
								<h3>
								<span>
								السعر:
								</span>
								  {{ $price }}
                        {{ getMainCurrency() }}
								
								</h3>
				</div>
				{{-- {{ dd($paymentFrame) }} --}}
                <iframe id="payment-iframe" scrolling="no" style="width:100%;height:900px;" src="{{$paymentFrame}}">

                </iframe>
                {{-- {{  }} --}}
                {{-- <form class="payment-form" action="{{ route('exams.checkout') }}" method="get">
                <h3 class="Tajawal-font">دفع باي بال : <img class="pay-imgs" src="{{ asset('images/visa.png') }}" alt=""></h3>
                <div class="row col-50">
                    <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                    <div class="text-center">
                        <button type="submit" class="btn">ادفع الآن</button>
                    </div>
                </div>
                </form> --}}
            </div>
            {{--<div id="master-card" class="tabcontent">--}}
            {{--<form class="payment-form" action="index.html" method="post">--}}
            {{--<h3 class="Tajawal-font">دفع بالماستر كارد:  <img class="pay-imgs" src="{{ asset('images/master-card.png') }}" alt=""></h3>--}}
            {{--<div class="row col-50">--}}
            {{--<div class="form-group col-md-12">--}}
            {{--<label for="cname">Name on Card</label>--}}
            {{--<input type="text" id="cname" name="cardname" placeholder="John More Doe">--}}
            {{--</div>--}}
            {{--<div class="form-group col-md-12">--}}
            {{--<label for="ccnum">Credit card number</label>--}}
            {{--<input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444">--}}
            {{--</div>--}}
            {{--<div class="form-group col-md-6">--}}
            {{--<label for="expmonth">Exp Month</label>--}}
            {{--<input type="text" id="expmonth" name="expmonth" placeholder="September">--}}
            {{--</div>--}}
            {{--<div class="form-group col-md-6">--}}
            {{--<label for="expyear">Exp Year</label>--}}
            {{--<input type="text" id="expyear" name="expyear" placeholder="2018">--}}
            {{--</div>--}}
            {{--<div class="form-group col-md-12">--}}
            {{--<label for="cvv">CVV</label>--}}
            {{--<input type="text" id="cvv" name="cvv" placeholder="352">--}}
            {{--</div>--}}
            {{--<div class="text-center">--}}
            {{--<a href="quiz-intro.html" class="btn">إدفع الآن</a>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</form>--}}
            {{--</div>--}}
            {{--<div id="Tokyo" class="tabcontent">--}}
            {{--<form class="payment-form" action="index.html" method="post">--}}
            {{--<h3 class="Tajawal-font">دفع بسداد  <img class="pay-imgs" src="{{ asset('images/sadad.jpg') }}" alt=""></h3>--}}
            {{--<div class="row col-50">--}}
            {{--<div class="form-group col-md-12">--}}
            {{--<label for="cname">اسم مستخدم حساب سداد</label>--}}
            {{--<input type="text" id="cname" name="cardname" placeholder="أدخل اسم مستخدم حساب سداد هنا">--}}
            {{--</div>--}}
            {{--<div class="text-center">--}}
            {{--<a href="quiz-intro.html" class="btn">إدفع الآن</a>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</form>--}}
            {{--</div>--}}
        </div>
    </div>
</section>
@push('js')
	
@endpush
@endsection
