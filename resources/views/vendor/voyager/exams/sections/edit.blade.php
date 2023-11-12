@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title')
    تعديل القسم
@endsection
@section('breadcrumbs')
@endsection
@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <form action="{{ route('admin.exam_sections.update', $section) }}"
                          role="form" class="form-edit-add" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
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
                                <input type="text" name="title" id="title" class="form-control" value="{{ $section->section_title }}">
                            </div>
                            <div class="form-group">
                                <label for="order">الترتيب</label>
                                <input type="number" name="order" id="order" class="form-control" min="0" value="{{ $section->section_order }}">
                            </div>
                            <div class="form-group col-md-12">
                                <label class="control-label" for="status">مفعل ؟</label>
                                <input type="checkbox" name="status" id="status" {{ $section->status == 1 ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="panel-footer">
                            @section('submit-buttons')
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