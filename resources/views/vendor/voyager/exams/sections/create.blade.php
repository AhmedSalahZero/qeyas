@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title')
    اضافة قسم
@endsection
@section('breadcrumbs')
@endsection
@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <form action="{{ route('admin.exam_sections.store', $exam) }}"
                          role="form" class="form-edit-add" method="post">
                        {{ csrf_field() }}
                        <div class="panel-body">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="title">العنوان</label>
                                <input type="text" name="title[]" id="title" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="order">الترتيب</label>
                                <input type="number" name="order[]" id="order" class="form-control" min="0">
                            </div>
                            <div class="form-group col-md-12">
                                <label class="control-label" for="status">مفعل ؟</label>
                                <input type="checkbox" name="status[]" id="status">
                            </div>
                        </div>
                        <div class="panel-footer">
                            @section('submit-buttons')
                                <button type="button" class="btn btn-success" onclick="add_new()">اضافة جديد</button>
                                <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                            @stop
                            @yield('submit-buttons')
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        function add_new(){
            var form ="                            <div class=\"form-group\">\n" +
                "                                <label for=\"title\">العنوان</label>\n" +
                "                                <input type=\"text\" name=\"title[]\" id=\"title\" class=\"form-control\">\n" +
                "                            </div>\n" +
                "                            <div class=\"form-group\">\n" +
                "                                <label for=\"order\">الترتيب</label>\n" +
                "                                <input type=\"number\" name=\"order[]\" id=\"order\" class=\"form-control\" min=\"0\">\n" +
                "                            </div>\n" +
                "                            <div class=\"form-group col-md-12\">\n" +
                "                                <label class=\"control-label\" for=\"status\">مفعل ؟</label>\n" +
                "                                <input type=\"checkbox\" name=\"status[]\" id=\"status\">\n" +
                "                            </div>";
            $('.panel-body').append(form);
        }
    </script>
@endsection