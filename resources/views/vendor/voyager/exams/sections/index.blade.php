@extends('voyager::master')

@section('page-title')
    {{ $exam->title }} - الاقسام
@endsection
@section('page_title')
    {{ $exam->title }} - الاقسام
@endsection
@section('breadcrumbs')
@endsection
@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            {{ $exam->title }} - الاقسام
        </h1>
		@can('edit',$exam)
        <a href="{{ route('admin.exam_sections.create', $exam) }}" class="btn btn-success btn-add-new">
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
                                    <th>العنوان</th>
                                    <th>الترتيب</th>
                                    <th>الحالة</th>
									@can('edit',$exam)
                                    <th class="actions text-right">{{ __('voyager::generic.actions') }}</th>
									@endcan
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($exam->sections as $section)
                                    <tr>
                                        <td>
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                            {{ $section->section_title }}
                                        </td>
                                        <td>
                                            {{ $section->section_order }}
                                        </td>
                                        <td>
                                            @if($section->status)
                                                <span class="label label-info">مفعل</span>
                                            @else
                                                <span class="label label-primary">غير مفعل</span>
                                            @endif
                                        </td>
										@can('edit',$exam)
                                        <td>
                                            <a href="javascript:" title="حذف" class="btn btn-sm btn-danger pull-right delete" data-id="{{ $section->id }}" id="{{ 'delete-'.$section->id }}">
                                                <i class="voyager-trash"></i>
                                                <span class="hidden-sm hidden-xs">حذف</span>
                                            </a>
                                            <a class="btn btn-sm btn-info pull-right" href="{{ route('admin.exam_sections.edit', $section->id) }}">تعديل</a>
                                        </td>
										@endcan 
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
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} هذا القسم?</h4>
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
@endsection
@section('javascript')
    <script>
        $('td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = '{{ route('admin.exam_sections.delete', ['id' => '__id']) }}'.replace('__id', $(this).data('id'));
            $('#delete_modal').modal('show');
        });

    </script>
@stop
