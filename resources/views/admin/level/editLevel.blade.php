@extends('main')

@section('content')

    <div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Sửa thông tin lớp học</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route'=>['admin.levels.update', $level->id], 'method'=>'put','class'=>'form-horizontal']) !!}
                <div class="box-body">
                    @if(count($errors) > 0)
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Vui lòng nhập đầy đủ thông tin trước khi thay đổi!</h4>
                        @foreach($errors->all() as $error)
                            <li>{!! $error !!}</li>
                        @endforeach
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Tên lớp</label>
                        <div class="col-sm-10">
                            {!! Form::text('level_name', $level->level_name, ['class'=>'form-control', 'placeholder'=>'Chọn lớp học']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Khối học</label>
                        <div class="col-sm-10">
                            {!! Form::select('grade_id', $gradeArray, $level->grade_id,  ['class'=>'form-control', 'placeholder'=> 'Chọn khối học']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Ban học</label>
                        <div class="col-sm-10">
                            {!! Form::select('group_id', $groupArray, $level->group_id,  ['class'=>'form-control', 'placeholder'=> 'Chọn ban học']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Giáo viên chủ nhiệm</label>
                        <div class="col-sm-10">
                            {!! Form::select('teacher_id', $teacherArray, $level->teacher_id,  ['class'=>'form-control', 'placeholder'=> 'Chọn giáo viên chủ nhiệm']) !!}
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    {!! Form::submit('Cập nhật', ['class'=>'btn btn-primary']) !!}
                </div><!-- /.box-footer -->
            {!! Form::close() !!}
        </div><!-- /.box -->
    </div>
@stop
