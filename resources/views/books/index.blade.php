@extends('layouts.app')

@section('content')
    <section class="banner inner-page">
        <div class="banner-img"><img src="{{ asset('images/banner/register-bannerImg.jpg') }}" alt=""></div>
        <div class="page-title">
            <div class="container">
                <h1 class="Tajawal-font">الكتب الإلكترونية</h1>
            </div>
        </div>
    </section>
    <section class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="{{ route('home') }}">الرئيسية</a></li>
                <li><a href="{{ route('books.index') }}">الكتب الإلكترونية</a></li>
            </ul>
        </div>
    </section>
    <div class="user-dashboard">
        <div class="container">
            <div class="archived-course">
                @foreach($books as $book)
                    <div class="course-list">
                        <div class="img">
                            <a href="{{ route('books.show', $book) }}">
                              <img src="{{ Voyager::image($book->book_photo) }}" alt="">
                            </a>
                        </div>
                        <div class="info">
                            <div class="name Tajawal-font">
                                <a href="{{ route('books.show', $book) }}">{{ $book->book_title }}</a>
                            </div>
                            <div class="date">{{ $book->release_date }}</div>
                            <p>{{ str_limit($book->book_description, 200) }}</p>
                            {{-- <div class="view-btn2">
                                <a href="{{ route('books.show', $book) }}" class="btn2">التفاصيل</a>
                            </div> --}}
                            <div class="btn-block">
                                @auth('web')
                                    {{--@if($book->book_price == 0 || Auth::user()->has_book($book->id))--}}
                                        <a href="{{ route('books.view', $book) }}" class="btn">تصفح الكتاب</a>
										@if(!auth()->user()->has_book($book->id))
                                        <a href="{{ route('books.show', $book) }}" class="btn3"><i class="fa fa-book" aria-hidden="true"></i> شراء الكتاب</a>
										@endif
                                        {{-- <a href="{{ route('books.download', $book) }}" class="btn3"><i class="fa fa-download" aria-hidden="true"></i> تحميل الكتاب</a> --}}
                                    {{--@endif--}}
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
                {{ $books->links() }}
            </div>
        </div>
    </div>
@endsection
