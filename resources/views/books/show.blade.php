@extends('layouts.app')

@section('content')
<style>
    .required {
        color: red;
        font-weight: bold;
    }

    .mb-8 {
        margin-bottom: 4rem;
    }

    .mt-8 {
        margin-top: 4rem;
    }

</style>
<section class="banner inner-page">
    <div class="banner-img"><img src="{{ asset('images/banner/register-bannerImg.jpg') }}" alt=""></div>
    <div class="page-title">
        <div class="container">
            <h1 class="Tajawal-font">شراء الكتاب</h1>
        </div>
    </div>
</section>
<section class="breadcrumb">
    <div class="container">
        <ul>
            <li><a href="{{ route('home') }}">الرئيسية</a></li>
            <li><a href="{{ route('books.index') }}">الكتب الإلكترونية</a></li>
            <li>{{ $book->book_title }}</li>
        </ul>
    </div>
</section>
<div class="blog-page blog-details">
    @if(session('fail'))
    <div class="alert alert-danger text-center">
        {{ session('fail') }}
    </div>
    @elseif(session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="blog-slide">
                    <div class="img" style="min-height: 100px;">
                        <img src="{{ Voyager::image($book->book_photo, asset('images/blog/img1.jpg')) }}" alt="">
                        <div class="date">
                            <span class="fontsize-30">{{ $book->book_price }} {{ getMainCurrency() }}</span>
                        </div>
                    </div>
                    <div class="info">
                        <div class="name">
                            {{ $book->book_title }}
                        </div>
                        <div class="post-info">
                            <span><i class="fa fa-calendar"></i>{{ $book->release_date }}</span>
                        </div>
                        <p>{{ $book->book_description }}</p>
                        <div class="btn-block">
                            @if($book->book_price == 0 || (Auth::check() && Auth::user()->has_book($book->id)))
                            <a href="{{ route('books.view', $book) }}" class="btn">تصفح الكتاب</a>
                            <a href="{{ route('books.download', $book) }}" class="btn3"><i class="fa fa-download" aria-hidden="true"></i> تحميل الكتاب</a>
                            @else

                            <form action="{{ route('books.buy',['book'=>$book->id]) }}" method="post">
							@csrf 
                                <input id="book-price" type="hidden" name="price" value="{{ $book->book_price }}">

                                <div class="row mb-8 mt-8 text-center">
                                    <h3>نموذج شراء الكتاب</h3>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">الاسم
                                                <span class="required">*</span>
                                            </label>
                                            <input name="name" id="name" placeholder="ادخل اسمك كاملا" value="{{ old('name') }}" type="text" required class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">رقم الهاتف
                                                <span class="required">*</span>
                                            </label>
                                            <input name="phone" id="phone" placeholder="ادخل رقم هاتفك" value="{{ old('phone') }}" type="text" required class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">العنوان
                                                <span class="required">*</span>
                                            </label>
                                            <input name="address" id="address" placeholder="ادخل عنوان الاستلام" value="{{ old('address') }}" type="text" required class="form-control">
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">البريد الالكتروني
                                            </label>
                                            <input name="email" id="email" placeholder="ادخل بريدك الالكتروني (اخيتاري) " value="{{ old('email') }}" type="email" required class="form-control">
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="no_books">عدد النسخ
                                            </label>
                                            <input name="no_books" id="no_books" placeholder="عدد النسخ" value="{{ old('no_books') ?:1 }}" type="numeric" step="1" required class="form-control">
                                        </div>
                                    </div>

                                </div>
                                {{-- <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                </div> --}}
                                {{-- <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                </div> --}}
                                {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                                <div class="text-center d-flex justify-items-center align-items-center mb-8 mt-8" style="font-size:2rem;">
                                    السعر الاجمالي :
                                    <span id="total-price">0</span>
                                </div>
                                <div class="text-center">
                                    <button type="submit"  class="btn">اشترِ الكتاب</button>
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
<script>
    $('#no_books').change(function() {
        const noBooks = $(this).val() ? parseInt($(this).val()) : 0;
        const bookPrice = parseFloat($('#book-price').val());
        const totalPrice = noBooks * bookPrice;
		if(totalPrice  == 0 ){
        $('#total-price').html("مجاني");
			
		}else{
        $('#total-price').html(totalPrice + "{{ getMainCurrency() }}");
			
		}
    })
    $(function() {
        $('#no_books').trigger('change')
    })

</script>
@endpush
@endsection
