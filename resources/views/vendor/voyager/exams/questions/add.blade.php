@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page-title')
    اضافة السؤال
@endsection

@section('breadcrumbs')
@endsection

@section('content')

    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <form action="{{ route('admin.exam_questions.store') }}"
                          role="form" class="form-edit-add" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="panel-body" id="form">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="question_block">

                            </div>
                        </div>

                        <div class="form-group col-md-12 ">
                            <label class="control-label" for="question_text">قسم السؤال</label>
                            <select class="form-control" name="section_id">
                                <option selected disabled>إختر القسم</option>
                                @foreach($sections as $section)
                                    <option value="{{$section->id}}">{{$section->section_title}}</option>
                                @endforeach
                            </select>
                        </div>

                        <input type="hidden" name="exam" value="{{ $exam->id }}">
                        <div class="panel-footer">
                            {{--                            <button type="button" class="btn btn-success" onclick="add_question()">اضافة خيار</button>--}}
                            @section('submit-buttons')
                                <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                            @stop
                            @yield('submit-buttons')
                        </div>
                    </form>
                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                    <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                          enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                        <input name="image" id="upload_file" type="file"
                               onchange="$('#my_form').submit();this.value='';">
                        <input type="hidden" name="type_slug" id="type_slug" value="exam-questions">
                        {{ csrf_field() }}
                    </form>
                    {{-- <button class="btn btn-primary" onclick="new_question()">أضف سؤال جديد</button> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        var i = 0;

        $(document).ready(function () {
            tinymce.init({
                menubar: !1,
                selector: "textarea.richTextBox",
                skin_url: $('meta[name="assets-path"]').attr("content") + "?path=js/skins/voyager",
                min_height: 200,
                resize: "vertical",
                plugins: "link, image, code, table, textcolor, lists",
                extended_valid_elements: "input[id|name|value|type|class|style|required|placeholder|autocomplete|onclick]",
                file_browser_callback: function(e, t, n, r) {
                    "image" == n && $("#upload_file").trigger("click")
                },
                toolbar: "styleselect bold italic underline | forecolor backcolor | alignleft aligncenter alignright | bullist numlist outdent indent | link image table | code",
                convert_urls: !1,
                image_caption: !0,
                image_title: !0,
                init_instance_callback: function(e) {
                    "undefined" != typeof tinymce_init_callback && tinymce_init_callback(e)
                },
                setup: function(e) {
                    "undefined" != typeof tinymce_setup_callback && tinymce_setup_callback(e)
                }
            });

            $('.question_block').append
            (
                '<div class="form-group col-md-12">\n' +
                    '<label class="control-label" for="question_text">القطعة</label>\n' +
                    '<textarea name="array[' + i + '][paragraph]" class="form-control richTextBox" id="richTextParagraph' + i +'"></textarea>\n' +
                '</div>\n' +

                '<div class="form-group col-md-12 ">\n' +
                    '<label class="control-label" for="">نص السؤال</label>\n' +
                    '<textarea name="array[' + i + '][question_text]" class="form-control richTextBox" id="richTextQuestion' + i +'"></textarea>\n' +
                '</div>\n' +

                '<div class="form-group col-md-12">\n' +
                    '<label class="control-label" for="">صورة السؤال</label>\n' +
                    '<input type="file" name="array[' + i + '][question_image]" accept="image/*">\n' +
                '</div>\n' +

                '<h3>خيارات السؤال:</h3>\n' +
                '<hr>'+

                '<div class="col-md-12" style="margin-top: 10px;">\n' +
                    '<label for="option_text">النص</label>\n' +
                    '<textarea name="array[' + i + '][options][][answer_text]" class="form-control richTextBox" id="richTextAnswer1' + i +'"></textarea>\n' +
                    '<label for="option_img">الصورة</label>\n' +
                    '<input type="file" name="array[' + i + '][options][][answer_image]">\n' +
                    '<ul class="radio">\n' +
                    '<li>\n' +
                    '<input type="radio" name="array[' + i + '][answer]" id="is_correct0'+i+'" value="0">\n' +
                    '<label class="control-label" for="is_correct0'+i+'">\n' +
                    'الاجابة الصحيحة ؟\n' +
                    '</label>\n' +
                    '<div class="check"></div>\n' +
                    '</li>\n' +
                    '</ul>'+
                '</div>\n' +

                '<div class="col-md-12" style="margin-top: 10px;">\n' +
                    '<label for="option_text">النص</label>\n' +
                    '<textarea name="array[' + i + '][options][][answer_text]" class="form-control richTextBox" id="richTextAnswer2' + i +'"></textarea>\n' +
                    '<label for="option_img">الصورة</label>\n' +
                    '<input type="file" name="array[' + i + '][options][][answer_image]">\n' +
                    '<ul class="radio">\n' +
                    '<li>\n' +
                    '<input type="radio" name="array[' + i + '][answer]" id="is_correct1'+i+'" value="1">\n' +
                    '<label class="control-label" for="is_correct1'+i+'">\n' +
                    'الاجابة الصحيحة ؟\n' +
                    '</label>\n' +
                    '<div class="check"></div>\n' +
                    '</li>\n' +
                    '</ul>'+
                '</div>\n' +

                '<div class="col-md-12" style="margin-top: 10px;">\n' +
                    '<label for="option_text">النص</label>\n' +
                    '<textarea name="array[' + i + '][options][][answer_text]" class="form-control richTextBox" id="richTextAnswer3' + i +'"></textarea>\n' +
                    '<label for="option_img">الصورة</label>\n' +
                    '<input type="file" name="array[' + i + '][options][][answer_image]">\n' +
                    '<ul class="radio">\n' +
                    '<li>\n' +
                    '<input type="radio" name="array[' + i + '][answer]" id="is_correct2'+i+'" value="2">\n' +
                    '<label class="control-label" for="is_correct2'+i+'">\n' +
                    'الاجابة الصحيحة ؟\n' +
                    '</label>\n' +
                    '<div class="check"></div>\n' +
                    '</li>\n' +
                    '</ul>'+
                '</div>\n' +
                '<div class="col-md-12" style="margin-top: 10px;">'+
                    '<label for="option_text">النص</label>\n' +
                    '<textarea name="array[' + i + '][options][][answer_text]" class="form-control richTextBox" id="richTextAnswer4' + i +'"></textarea>\n' +
                    '<label for="option_img">الصورة</label>\n' +
                    '<input type="file" name="array[' + i + '][options][][answer_image]">\n' +
                    '<ul class="radio">\n' +
                    '<li>\n' +
                    '<input type="radio" name="array[' + i + '][answer]" id="is_correct3'+i+'" value="3">\n' +
                    '<label class="control-label" for="is_correct3'+i+'">\n' +
                    'الاجابة الصحيحة ؟\n' +
                    '</label>\n' +
                    '<div class="check"></div>\n' +
                    '</li>\n' +
                    '</ul>'+
                '</div>\n' +
                '<div class="form-group col-md-12">\n' +
                '<label class="control-label" for="">  التعليل</label>\n'+
                '<textarea name="array[' + i + '][explanation]" class="form-control richTextBox" id="richTextExplanation' + i +'"></textarea>\n' +
                '</div>'
            );

            tinyMCE.EditorManager.execCommand('mceAddEditor', false, 'richTextExplanation' + i);
            tinyMCE.EditorManager.execCommand('mceAddEditor', false, 'richTextQuestion' + i);
            tinyMCE.EditorManager.execCommand('mceAddEditor', false, 'richTextParagraph' + i);
            tinyMCE.EditorManager.execCommand('mceAddEditor', false, 'richTextAnswer1' + i);
            tinyMCE.EditorManager.execCommand('mceAddEditor', false, 'richTextAnswer2' + i);
            tinyMCE.EditorManager.execCommand('mceAddEditor', false, 'richTextAnswer3' + i);
            tinyMCE.EditorManager.execCommand('mceAddEditor', false, 'richTextAnswer4' + i);
            i++;

        });

        function new_question() {
            $('.question_block').append
            (
                '<div class="col-md-12">\n' +
                '<hr style="border: 1px solid #007a80;">\n' +
                '</div>' +
                '<div class="form-group col-md-12">\n' +
                '<label class="control-label" for="question_text">القطعة</label>\n' +
                '<textarea name="array[' + i + '][paragraph]" class="form-control richTextBox" id="richTextParagraph' + i +'"></textarea>\n' +
                '</div>\n' +
                '<div class="form-group col-md-12 ">\n' +
                    '<label class="control-label" for="question_text">نص السؤال</label>\n' +
                    '<textarea name="array[' + i + '][question_text]" class="form-control richTextBox" id="richTextQuestion' + i +'"></textarea>\n' +
                '</div>\n' +

                '<div class="form-group col-md-12">\n' +
                    '<label class="control-label" for="">صورة السؤال</label>\n' +
                    '<input type="file" name="array[' + i + '][question_image]" accept="image/*">\n' +
                '</div>\n' +

                '<h3>خيارات السؤال:</h3>\n' +
                '<hr>' +

                '<div class="col-md-12" style="margin-top: 10px;">\n' +
                    '<label for="option_text">النص</label>\n' +
                    '<textarea name="array[' + i + '][options][][answer_text]" class="form-control richTextBox" id="richTextAnswer1' + i +'"></textarea>\n' +
                    '<label for="option_img">الصورة</label>\n' +
                    '<input type="file" name="array[' + i + '][options][][answer_image]">\n' +
                    '<ul class="radio">\n' +
                    '<li>\n' +
                    '<input type="radio" name="array[' + i + '][answer]" id="is_correct0'+i+'" value="0">\n' +
                    '<label class="control-label" for="is_correct0'+i+'">\n' +
                    'الاجابة الصحيحة ؟\n' +
                    '</label>\n' +
                    '<div class="check"></div>\n' +
                    '</li>\n' +
                    '</ul>'+
                '</div>\n' +
                '<div class="col-md-12" style="margin-top: 10px;">\n' +
                    '<label for="option_text">النص</label>\n' +
                    '<textarea name="array[' + i + '][options][][answer_text]" class="form-control richTextBox" id="richTextAnswer2' + i +'"></textarea>\n' +
                    '<label for="option_img">الصورة</label>\n' +
                    '<input type="file" name="array[' + i + '][options][][answer_image]">\n' +
                    '<ul class="radio">\n' +
                    '<li>\n' +
                    '<input type="radio" name="array[' + i + '][answer]" id="is_correct1'+i+'" value="1">\n' +
                    '<label class="control-label" for="is_correct1'+i+'">\n' +
                    'الاجابة الصحيحة ؟\n' +
                    '</label>\n' +
                    '<div class="check"></div>\n' +
                    '</li>\n' +
                    '</ul>'+
                '</div>\n' +
                '<div class="col-md-12" style="margin-top: 10px;">\n' +
                    '<label for="option_text">النص</label>\n' +
                    '<textarea name="array[' + i + '][options][][answer_text]" class="form-control richTextBox" id="richTextAnswer3' + i +'"></textarea>\n' +
                    '<label for="option_img">الصورة</label>\n' +
                    '<input type="file" name="array[' + i + '][options][][answer_image]">\n' +
                    '<ul class="radio">\n' +
                    '<li>\n' +
                    '<input type="radio" name="array[' + i + '][answer]" id="is_correct2'+i+'" value="2">\n' +
                    '<label class="control-label" for="is_correct2'+i+'">\n' +
                    'الاجابة الصحيحة ؟\n' +
                    '</label>\n' +
                    '<div class="check"></div>\n' +
                    '</li>\n' +
                    '</ul>'+
                '</div>\n' +
                '<div class="col-md-12" style="margin-top: 10px;">\n' +
                    '<label for="option_text">النص</label>\n' +
                    '<textarea name="array[' + i + '][options][][answer_text]" class="form-control richTextBox" id="richTextAnswer4' + i +'"></textarea>\n' +
                    '<label for="option_img">الصورة</label>\n' +
                    '<input type="file" name="array[' + i + '][options][][answer_image]">\n' +
                    '<ul class="radio">\n' +
                    '<li>\n' +
                    '<input type="radio" name="array[' + i + '][answer]" id="is_correct3'+i+'" value="3">\n' +
                    '<label class="control-label" for="is_correct3'+i+'">\n' +
                    'الاجابة الصحيحة ؟\n' +
                    '</label>\n' +
                    '<div class="check"></div>\n' +
                    '</li>\n' +
                    '</ul>'+
                '</div>\n' +
                '<div class="form-group col-md-12">\n' +
                    '<label class="control-label" for=""> التعليل </label>\n' +
                    '<textarea name="array[' + i + '][explanation]" class="form-control richTextBox" id="richTextExplanation' + i + '" ></textarea>\n' +
                '</div>'
            );
            tinyMCE.EditorManager.execCommand('mceAddEditor', false, 'richTextExplanation' + i);
            tinyMCE.EditorManager.execCommand('mceAddEditor', false, 'richTextQuestion' + i);
            tinyMCE.EditorManager.execCommand('mceAddEditor', false, 'richTextParagraph' + i);
            tinyMCE.EditorManager.execCommand('mceAddEditor', false, 'richTextAnswer1' + i);
            tinyMCE.EditorManager.execCommand('mceAddEditor', false, 'richTextAnswer2' + i);
            tinyMCE.EditorManager.execCommand('mceAddEditor', false, 'richTextAnswer3' + i);
            tinyMCE.EditorManager.execCommand('mceAddEditor', false, 'richTextAnswer4' + i);
            i++;
        }
    </script>
@endsection
