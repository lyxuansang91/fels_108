@extends('main')s

@section('content')
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Thông tin giáo viên</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    @if(session()->has('failed'))
                        <div class="alert alert-warning alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                            {!! session('failed') !!}
                        </div>
                    @endif

                    @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4>Success!</h4>
                            {!! session('success') !!}
                        </div>
                    @endif
                    <h3>Mã giáo viên: {{$teacher->teacher_code}} </h3>
                    <h5>Tên giáo viên: {{$teacher->teacher_name}} </h5>
                    <h3>Nhập lịch giảng dạy </h3>
                    {!! Form::open(['route'=>'admin.teachers.updateCalendar', 'class'=>'form-horizontal', 'files' => true]) !!}
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
                                <label for="inputEmail3" class="col-sm-2 control-label">Thời khóa biểu</label>
                                <div class="col-sm-10">
                                    @if ($semester_teacher)
                                        <span>{!! HTML::image($semester_teacher->teacher_calendar, 'Teacher Calendar', ['style'=>'width: 100%; max-width: 150px; height: 150px;']) !!} </span>
                                    @endif
                                    {!! Form::hidden('teacher_id', $teacher->id)  !!}
                                    {!! Form::file('teacher_calendar', '', ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            {!! Form::submit('Thêm thời khóa biểu', ['class'=>'btn btn-primary']) !!}
                        </div><!-- /.box-footer -->
                    {!! Form::close() !!}
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->

</section><!-- /.content -->
@stop
