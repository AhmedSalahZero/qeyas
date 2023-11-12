@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page-title')
    تعديل السؤال
@endsection
@section('breadcrumbs')
@endsection
@section('content')

    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <form action="{{ route('admin.exam_questions.update', $question->id) }}"
                          role="form" class="form-edit-add" method="post" enctype="multipart/form-data">
                        {{ method_field('PUT') }}
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
                            <div class="form-group col-md-12">
                                <label class="control-label" for="richTextParagraph">القطعة</label>
                                <textarea name="paragraph" class="form-control richTextBox" id="richTextParagraph">{!! switch_numbers($question->paragraph, 'en') ?? '' !!}</textarea>
                                {{-- <textarea name="paragraph" class="form-control richTextBox" id="richTextParagraph">{!! switch_numbers($question->paragraph, $question->exam->lang) ?? '' !!}</textarea> --}}
                            </div>
                            <div class="form-group col-md-12 {{ $errors->has('question_text') ? 'has-error' : '' }}">
                                <label class="control-label" for="question_text">نص السؤال</label>
                                {{--<input class="form-control" type="text" name="question_text" id="question_text" value="{{ $question->question_text ?? '' }}">--}}
                                <textarea name="question_text" class="richTextBox" id="question_text" cols="20" rows="10">{!! switch_numbers($question->question_text, 'en') ?? '' !!}</textarea>
                            </div>
                            <div class="form-group col-md-12 {{ $errors->has('question_img') ? 'has-error' : '' }}">
                                <label class="control-label" for="">صورة السؤال</label>
                                @if(isset($question->question_img))
                                    <div data-field-name="question_img">
                                        <img src="{{ Voyager::image($question->question_img) }}"
                                             data-file-name="{{ $question->question_img }}" data-id="{{ $question->id }}"
                                             style="max-width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;">
                                    </div>
                                @endif
                                <input type="file" name="question_img" accept="image/*">
                            </div>
                            <div class="form-group col-md-12 ">
                                <label class="control-label" for="question_section">قسم السؤال</label>
                                <select class="form-control" name="section_id">
                                    <option disabled>إختر القسم</option>
                                    @foreach($question->exam->sections()->orderBy('section_order', 'asc')->get() as $section)
                                        <option value="{{$section->id}}" {{ $question->section_id == $section->id ? 'selected' : "" }}>
                                            {{$section->section_title}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <h3>خيارات السؤال:</h3>
                            <hr>
                            <div class="form-group col-md-12" id="options">
                                @foreach($question->options as $option)
                                    <a href="javascript:" title="حذف" class="btn btn-sm btn-danger pull-right delete" data-id="{{ $option->id }}" id="{{ 'delete-'.$option->id }}">
                                        <i class="voyager-trash"></i>
                                        <span class="hidden-sm hidden-xs">حذف</span>
                                    </a>
                                    <h4>{{ ${'list_index_' . $question->exam->lang}[$loop->index + 1] ?? $loop->index + 1 }} -</h4>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <label for="richTextAnswer{{ $loop->index + 1 }}">الاجابة النصية</label>
                                        <textarea name="option_text[]" class="form-control richTextBox" id="richTextAnswer{{ $loop->index + 1 }}">{!! switch_numbers(strip_tags($option->option_text,"<p><a><img><span><strong><u><table>"), $question->exam->lang) ?? '' !!}</textarea>
                                        {{--<input class="form-control" id="option_text{{ $loop->index + 1 }}" type="text" name="option_text[]" value="{{ $option->option_text ?? '' }}">--}}
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <label class="control-label" for="">الاجابة المرئية</label>
                                        @if($option->option_img)
                                            <div data-field-name="option_img">
                                                <a href="#" class="voyager-x remove-single-image" style="position:absolute;"></a>
                                                <img src="{{ Voyager::image( $option->option_img) }}"
                                                     data-file-name="{{ $option->option_img }}" data-id="{{ $option->id }}"
                                                     alt=""
                                                     style="max-width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;">
                                            </div>
                                        @endif
                                        <input type="file" name="option_img[]">
                                    </div>
                                    <div class="col-md-12 form-group" style="margin-top: 10px;">
                                        <ul class="radio">
                                            <li>
                                                <input type="radio" name="is_correct" id="right_answer{{ $loop->index + 1 }}" value="{{ $option->id }}" {{ $option->is_correct ? 'checked' : '' }}>
                                                <label class="control-label" for="right_answer{{ $loop->index + 1 }}">
                                                    الاجابة الصحيحة ؟
                                                </label>
                                                <div class="check"></div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12">
                                        <hr style="border: 1px solid #007a80;">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="button" class="btn btn-success" onclick="add_option()">اضافة خيار</button>
                        </div>
                        <div class="col-md-12">
                            <label for="richtextexplanation">تعليل السؤال :</label>
                            <textarea name="explanation" class="richTextBox" id="richtextexplanation">{!! switch_numbers($question->explanation, $question->exam->lang) ?? '' !!}</textarea>
                        </div>
                        <div class="panel-footer">
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
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} هذه الاجابة؟</h4>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="{{ __('voyager::generic.delete_confirm') }}">
                    </form>
                    <button style="margin-left: 10px" type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade modal-danger" id="confirm_delete_modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;
                    </button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
                </div>

                <div class="modal-body">
                    <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        // tinyMCE.EditorManager.execCommand('mceAddEditor', false, 'richtextexplanation');
        let option_count = parseInt({{ $question->options->count() }});
        let list_index_{{ $question->exam->lang }} = JSON.parse('{!! json_encode(${'list_index_' . $question->exam->lang}) !!}');
        function add_option() {
            let option_index = list_index_{{ $question->exam->lang }}[(option_count + 1)] ? list_index_{{ $question->exam->lang }}[(option_count + 1)] : (option_count + 1);
            let option =
                '<h4>' + option_index + ' -</h4>' +
                '<div class="col-md-12" style="margin-top: 10px;">' +
                '<label for="">الاجابة النصية</label>\n' +
                '<textarea name="option_text[]" class="form-control richTextBox" id="richTextAnswer'+(option_count + 1)+'"></textarea>' +
                '</div>' +
                '<div class="col-md-12" style="margin-top: 10px;">' +
                '<label>الاجابة المرئية</label> ' +
                '<input type="file" name="option_img[]" style="margin-top: 10px;">\n' +
                '</div>' +
                '<div class="col-md-12">\n' +
                '<hr style="border: 1px solid gray;">\n' +
                '</div>'
            ;
            $('#options').append(option);
            tinyMCE.EditorManager.execCommand('mceAddEditor', false, 'richTextAnswer' + parseInt(option_count+1) );
            option_count += 1;
        }

        var params = {};
        var $file;

        function deleteHandler(tag, isMulti) {
            return function () {
                $file = $(this).siblings(tag);

                params = {
                    slug: 'question-options',
                    filename: $file.data('file-name'),
                    id: $file.data('id'),
                    field: $file.parent().data('field-name'),
                    multi: isMulti,
                    _token: '{{ csrf_token() }}'
                };

                $('.confirm_delete_name').text(params.filename);
                $('#confirm_delete_modal').modal('show');
            };
        }

        $('document').ready(function () {
            tinyMCE.remove();
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
            tinyMCE.EditorManager.execCommand('mceAddEditor', false, 'richTextParagraph' );

            $('.toggleswitch').bootstrapToggle();

            //Init datepicker for date fields if data-datepicker attribute defined
            //or if browser does not handle date inputs
            $('.form-group input[type=date]').each(function (idx, elt) {
                if (elt.type != 'date' || elt.hasAttribute('data-datepicker')) {
                    elt.type = 'text';
                    $(elt).datetimepicker($(elt).data('datepicker'));
                }
            });


            $('.side-body input[data-slug-origin]').each(function (i, el) {
                $(el).slugify();
            });


            $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));

            $('#confirm_delete').on('click', function () {
                $.post('{{ route('admin.exam_questions.remove_img') }}', params, function (response) {
                    if (response
                        && response.data
                        && response.data.status
                        && response.data.status == 200) {

                        toastr.success(response.data.message);
                        $file.parent().fadeOut(300, function () {
                            $(this).remove();
                        })
                    } else {
                        toastr.error("Error removing file.");
                    }
                });

                $('#confirm_delete_modal').modal('hide');
            });
            $('[data-toggle="tooltip"]').tooltip();
        });

        $('#options').on('click', '.delete', function () {
            $('#delete_form')[0].action = '{{ route('admin.exam_questions.delete_answer', ['id' => '__id']) }}'.replace('__id', $(this).data('id'));
            $('#delete_modal').modal('show');
        });
    </script>
@stop
