@extends('main')

@section('content')

    <div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Gửi tin nhắn</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route'=>'admin.messages.store', 'class'=>'form-horizontal']) !!}
                <div class="box-body">
                    @if(count($errors) > 0)
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        @foreach($errors->all() as $error)
                            <li>{!! $error !!}</li>
                        @endforeach
                    </div>
                    @endif
                    @if ($student_level)
                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">SĐT</label>
                        <div class="col-sm-10">
                            {!! Form::hidden('student_level_id', $student_level->id,  ['class'=>'form-control disabled']) !!}
                            <b> {{ $student_level->student->phone }} </b>
                        </div>
                    </div>
                    @endif

                    @if ($level)
                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Lớp</label>
                        <div class="col-sm-10">
                            {!! Form::hidden('level_id', $level->id,  ['class'=>'form-control disabled']) !!}
                            <b> {{ $level->grade->grade_name.'-'.$level->level_name }} </b>
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Nội dung tin nhắn</label>
                        <div class="col-sm-10">
                            {!! Form::textarea('text_message', null,  ['class'=>'form-control', 'placeholder'=> 'Nhập nội dung tin nhắn']) !!}
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    {!! Form::submit('Gửi tin nhắn', ['class'=>'btn btn-primary']) !!}
                </div><!-- /.box-footer -->
            {!! Form::close() !!}
        </div><!-- /.box -->
    </div>
@stop
