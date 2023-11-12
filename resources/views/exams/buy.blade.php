@extends('layouts.app')

@section('content')
<style>
.product-bg{
	width: 50%;
  text-align: center;
  margin: auto;
    margin-top: auto;
    margin-bottom: auto;
  background: #e6e6e6;
  padding: 1px;
  margin-bottom: 20px;
  margin-top: 20px;
}
</style>
<section class="banner inner-page">
    <div class="banner-img"><img src="{{ asset('images/banner/register-bannerImg.jpg') }}" alt=""></div>
    <div class="page-title">
        <div class="container">
            <h1 class="Tajawal-font">
                {{ $productDescription }}
            </h1>
        </div>
    </div>
</section>
<section class="breadcrumb">
    <div class="container">
        <ul>
            <li><a href="{{ route('home') }}">الرئيسية</a></li>
            <li><a href="{{ $breadCrumbLink }}">{{ $breadCrumbTitle }}</a></li>
            <li>{{ $breadCrumbLastTitle }}</li>
        </ul>
    </div>
</section>
<section class="courses-view list-view">
    <div class="container">
        <div class="row">

            {{-- <div class="test-price">
                <h3 class="Tajawal-font fontsize-30">السعر : {{ $price }} {{ getMainCurrency() }} </h3>
            </div> --}}

            <div id="visa" class="tabcontent">
                <form class="payment-form" action="{{ route('exams.checkout') }}" method="get">
                    {{-- <h3 class="Tajawal-font">دفع باي بال :  <img class="pay-imgs" src="{{ asset('images/visa.png') }}" alt=""></h3> --}}
                    <div class="row col-50">
                        {{-- <input type="hidden" name="exam_id" value="{{ $exam->id }}"> --}}
                        <div class="text-center" style="margin-bottom:40px;padding-top:30px;">
						<input type="hidden" name="product_description" value="{{ $productDescription }}">
						<input type="hidden" name="quantity" value="{{ $quantity }}">
						<input type="hidden" name="price" value="{{ $price }}">
						<input type="hidden" name="model_name" value="{{ $modelName }}">
						<input type="hidden" name="product_id" value="{{ $productId }}">
                            <h2 style="margin-bottom:20px;">مرحبا</h2>
                            <h2 style="margin-bottom:20px;">{{ auth()->user()->getName() }}</h2>
							
							<div class="product-bg">
								<h3>
								الاسم:
								{{ $productName }}
								</h3>
								
								@if($modelName == 'Book')
								<h3>
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
								{{ $price * $quantity}}
								{{ getMainCurrency() }}
								</h3>
								
								
							</div>
							
							@if(isset($additionalNote))
							<p style="margin-bottom:20px;margin-top:20px">
								{{ $additionalNote }}
							</p>
							@endif 
                            <p>يمكنك اجراء عمليه الشراء من خلال اتباع الرابط التالي </p>
							
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn">ادفع الآن</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
@endsection
