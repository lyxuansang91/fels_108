@extends('main')

@section('content')

<form action="" method="GET" role="form" class="col-md-6">
    <legend>Tìm kiếm</legend>
    <div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3">
        <select name="selectLevel" id="inputSelectLevel" class="form-control">
            @foreach ($levels as $item)
                <option value="{{ $item->id }}" @if($item->id == $selectLevel) selected @endif>{{ $item->grade->grade_name }} {{ $item->level_name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Tìm Kiếm</button>
</form>

    <div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Thêm nghỉ học</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route'=>'admin.absences.store', 'class'=>'form-horizontal']) !!}
                <div class="box-body">
                    @if(count($errors) > 0)
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Vui lòng nhập đầy đủ thông tin vào các ô trống!</h4>
                        @foreach($errors->all() as $error)
                            <li>{!! $error !!}</li>
                        @endforeach
                    </div>
                    @endif
                    <input type="hidden" name="semester_id" value= {{ $semester->id }} />
                    <input type="hidden" name="level_id" value= {{ $selectLevel }} />
                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Học sinh</label>
                        <div class="col-sm-10">
                            {!! Form::select('student_id', $students, NULL, ['class'=>'form-control', 'placeholder'=>'Nhập học sinh']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Môn học</label>
                        <div class="col-sm-10">
                            {!! Form::select('subject_id', $subjects , NULL, ['class'=>'form-control', 'placeholder'=>'Nhập môn học']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Lý do</label>
                        <div class="col-sm-10">
                            {!! Form::text('reason', '' , ['class'=>'form-control', 'placeholder'=>'Lý do xin nghỉ']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Ngày nghỉ</label>
                        <div class="col-sm-10">
                            {!! Form::date('absence_day', \Carbon\Carbon::now() , ['class'=>'form-control', 'placeholder'=>'Ngày nghỉ']) !!}
                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    {!! Form::submit('Tạo thông tin nghỉ học', ['class'=>'btn btn-primary']) !!}
                </div><!-- /.box-footer -->
            {!! Form::close() !!}
        </div><!-- /.box -->
    </div>
@stop
