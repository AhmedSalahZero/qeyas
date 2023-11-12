<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <!-- Meta information -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"><!-- Mobile Specific Metas -->

    <!-- Title -->
    <title>{{ $book->book_title }}</title>

    <!-- favicon icon -->
    <link rel="shortcut icon" href="{{ asset('images/Favicon.ico') }}">

    <!-- CSS Stylesheet -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet"><!-- bootstrap css -->
    <link href="{{ asset('css/bootstrap-rtl.min.css') }}" rel="stylesheet"><!-- bootstrap rtl css -->
    <link href="{{ asset('css/owl.carousel.css') }}" rel="stylesheet"><!-- carousel Slider -->
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet"><!-- font awesome -->
    <link href="{{ asset('css/docs.css') }}" rel="stylesheet"><!--  template structure css -->
    <link href="https://fonts.googleapis.com/css?family=Arima+Madurai:100,200,300,400,500,700,800,900%7CPT+Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Tajawal:500&display=swap" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <div class="container-fluid">
        <embed src="{{ Voyager::image($book->url) }}" type="application/pdf" width="100%" height="700px" />
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <script type="text/javascript" src="{{ asset('js/jquery-1.12.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/owl.carousel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.form-validator.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/placeholder.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/coustem.js') }}"></script>
</body>
</html>
