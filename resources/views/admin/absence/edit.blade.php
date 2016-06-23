@extends('main')

@section('content')

    <div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Sửa thông tin nghỉ học</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route'=>['admin.absences.update', $absence->id], 'method'=>'put','class'=>'form-horizontal']) !!}
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
                    <input type="hidden" name="semester_id" value= {{ $semester->id }} />
                    <div class="form-group">
                        <input type="hidden" name="student_level_id" value="{{ $absence->student_level_id }}" />
                        <label for="inputName3" class="col-sm-2 control-label">Học sinh</label>
                        <label for="inputName3" class="col-sm-1 control-label"> {{ $absence->student_level->student->student_code }}</label>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="subject_id" value="{{ $absence->subject_id }}" />
                        <label for="inputName3" class="col-sm-2 control-label">Môn học</label>
                        <label for="inputName3" class="col-sm-1 control-label"> {{ $absence->subject->subject_name }}</label>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Lý do</label>
                        <div class="col-sm-10">
                            {!! Form::text('reason', $absence->reason, ['class'=>'form-control', 'placeholder'=>'Lý do xin nghỉ']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Ngày nghỉ</label>
                        <div class="col-sm-10">
                            {!! Form::date('absence_day', $absence->absence_day , ['class'=>'form-control', 'placeholder'=>'Ngày nghỉ']) !!}
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
