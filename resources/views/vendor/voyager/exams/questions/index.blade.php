@extends('voyager::master')

@section('page_title')
    {{ $exam->title }} - الاسئلة
@endsection
@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            {{ $exam->title }} - الاسئلة
        </h1>
		@can('edit',$exam)
        <a href="{{ route('admin.exam_questions.create', $exam) }}" class="btn btn-success btn-add-new">
            <i class="voyager-plus"></i> <span>{{ __('voyager::generic.add_new') }}</span>
        </a>
		@endcan
    </div>
@endsection
@section('breadcrumbs')
@endsection
@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover">
                                <thead>
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>نص السؤال</th>
                                    <th>صورة السؤال</th>
                                    <th>الخيارات</th>
                                    <th>الاجابة الصحيحة</th>
										@can('edit',$exam)
                                    <th class="actions text-right">{{ __('voyager::generic.actions') }}</th>
									@endcan
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($exam->questions as $question)
                                    <tr>
                                        <td>
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td>{!! $question->question_text ?? '' !!}</td>
                                        <td>
                                            @if($question->question_img)
                                                <img src="@if( !filter_var($question->question_img, FILTER_VALIDATE_URL)){{ Voyager::image( $question->question_img ) }}@else{{ $question->question_img }}@endif" style="width:100px">
                                            @endif
                                        </td>
                                        <td>
                                            @if(! is_null($question->options))
                                                <ol>
                                                    @foreach($question->options as $option)
                                                        <li>{!! $option->option_text ?? '' !!}</li>
                                                        @if($option->option_img)
                                                            <img style="max-width: 200px;" src="@if( !filter_var($option->option_img, FILTER_VALIDATE_URL)){{ Voyager::image( $option->option_img ) }}@else{{ $option->option_img }}@endif">
                                                        @endif
                                                    @endforeach
                                                </ol>
                                            @endif
                                        </td>
                                        <td>{!! $question->right_answer->option_text ?? '' !!}</td>
                                        <td>
											@can('edit',$exam)
                                            <a href="javascript:" title="حذف" class="btn btn-sm btn-danger pull-right delete" data-id="{{ $question->id }}" id="{{ 'delete-'.$question->id }}">
                                                <i class="voyager-trash"></i>
                                                <span class="hidden-sm hidden-xs">حذف</span>
                                            </a>
                                            <a class="btn btn-sm btn-info pull-right" href="{{ route('admin.exam_questions.edit', $question->id) }}">تعديل</a>
                                        </td>
										@endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} هذا السؤال?</h4>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="{{ __('voyager::generic.delete_confirm') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@stop
@section('javascript')
    <script>
        $('td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = '{{ route('admin.exam_questions.delete', ['id' => '__id']) }}'.replace('__id', $(this).data('id'));
            $('#delete_modal').modal('show');
        });

    </script>
@stop
