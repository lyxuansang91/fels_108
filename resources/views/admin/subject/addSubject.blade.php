@extends('main')

@section('content')

    <div class="col-md-12 container">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Thêm mới môn học</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route'=>'admin.subjects.store', 'class'=>'form-horizontal', 'files'=>true]) !!}
                <div class="box-body">
                    @if(count($errors) > 0)
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Vui lòng nhập đầy đủ thông tin!</h4>
                        @foreach($errors->all() as $error)
                            <li>{!! $error !!}</li>
                        @endforeach
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Tên môn học</label>
                        <div class="col-sm-10">
                            {!! Form::text('subject_name', '', ['class'=>'form-control', 'placeholder'=>'Nhập tên môn học']) !!}
                        </div>
                    </div>

                    @if (count($groupArray) > 0)
                        @foreach($groupArray as $group)
                        <div class="form-group">
                            <label for="inputName3" class="col-sm-2 control-label">Hệ số {{{$group->group_name}}}</label>
                            <div class="col-sm-10">
                                {!! Form::text('group_'.$group->id, '', ['class'=>'form-control', 'placeholder'=>'Nhập hệ số'.$group->id]) !!}
                            </div>
                        </div>
                        @endforeach
                    @endif

                </div><!-- /.box-body -->
                <div class="box-footer">
                    {!! Form::submit('Create', ['class'=>'btn btn-primary']) !!}
                </div><!-- /.box-footer -->
            {!! Form::close() !!}
        </div><!-- /.box -->
    </div>
@stop
