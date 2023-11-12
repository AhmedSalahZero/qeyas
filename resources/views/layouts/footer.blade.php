<footer id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <h5>أقسام الإختبارات</h5>
                    <ul class="footer-link">
                        @foreach($categories as $category)
                            <li><a href="{{ route('categories.show', $category) }}">{{ $category->cat_name }}</a></li>
                        @endforeach
                        {{--<li><a href="terms%20&%20conditions.html">الإختبارات اللغوية</a></li>--}}
                        {{--<li><a href="privacy-policy.html">الإختبارات المهنية</a></li>--}}
                        {{--<li><a href="contact-us.html">الإختبارات الدولية</a></li>--}}
                    </ul>
                </div>
                @php($pages = \App\Page::where('active', 1)->get())
                <div class="col-sm-6 col-md-4">
                    <div class="col-md-offset-1 col-sm-6 col-md-5 col-xs-6">
                        <h5>روابط مهمة</h5>
                        <ul class="footer-link">
                            <li><a href="{{ route('about') }}">عن قياس2030</a></li>
                            <li><a href="{{ route('contact') }}">اتصل بنا</a></li>
                            <li><a href="{{ route('money.back') }}">سياسه ارجاع الاموال</a></li>
                            @foreach($pages as $page)
                                <li><a href="{{ route('pages', $page) }}">{{ $page->title }}</a></li>
                            @endforeach
                            {{--<li><a href="terms%20&%20conditions.html">الشروط والأحكام</a></li>--}}
                            {{--<li><a href="privacy-policy.html">سياسة الخصوصية</a></li>--}}
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <h5>مراسلة الإدارة</h5>
                    <div class="contact-view">
                        <div class="contact-slide">
                            <p><i class="fa fa-phone"></i>{{ setting('site.phone') }}</p>
                        </div>
                        <div class="contact-slide">
                            <p><i class="fa fa-envelope"></i><a href="mailTo:{{ setting('site.email') }}">{{ setting('site.email') }}</a></p>
                        </div>
						<div class="contact-slide">
                            <p><i class="fa fa-location-arrow"></i>
                            <a href="#">{{ setting('site.address') }}</a>							
							</p>
                        </div>
						
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="copy-right">
                    <p>Copyright © <span class="year">2019</span> قياس2030</p>
                </div>
            </div>
            <div class="col-sm-4 ">
                <div class="social-media">
                    <ul>
                        <li><a href="{{ setting('site.facebook', '#') }}"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="{{ setting('site.twitter', '#') }}"><i class="fa fa-twitter"></i></a></li>
                        {{--<li><a href="#"><i class="fa fa-skype"></i></a></li>--}}
                        <li><a href="{{ setting('site.youtube', '#') }}"><i class="fa fa-youtube"></i></a></li>
                        <li><a href="{{ setting('site.instagram', '#') }}"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
</div>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<script type="text/javascript" src="{{ asset('js/jquery-1.12.4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/owl.carousel.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.form-validator.min.js') }}"></script>
<script type='text/javascript' src='https://maps.google.com/maps/api/js?key=AIzaSyAciPo9R0k3pzmKu6DKhGk6kipPnsTk5NU'></script>
<script type="text/javascript" src="{{ asset('js/map-styleMain.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/placeholder.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/coustem.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@yield('scripts')
@stack('js')
<script>
    function openForm() {
        document.getElementById("myForm").style.display = "block";
    }

    function closeForm() {
        document.getElementById("myForm").style.display = "none";
    }
</script>
<script>


</script>
@if(session()->has('success'))
<script>
	
	Swal.fire(
  'تم',
  '{{ session()->get("success") }}',
  'success'
)
</script>

@endif 
{{-- 

@if(cacheHas('successMessage'))
<script>
	
	Swal.fire(
  'تم',
  '{{ cacheGetAndForget("successMessage") }}',
  'success'
)
</script>

@endif  --}}


@if(session()->has('fail'))
<script>
	Swal.fire({
  icon: 'error',
  title: 'خطا',
  text: '{{ session()->get("fail") }}',
})
</script>

@endif 
{{-- {{ dd(cacheHas('failMessage')) }} --}}
@if(auth()->check()&&cacheHas('failMessage'))
<script>
	Swal.fire(
  'خطا',
  '{{ cacheGetAndForget("failMessage") }}',
  'error'
)
</script>

@endif 

</body>
</html>
