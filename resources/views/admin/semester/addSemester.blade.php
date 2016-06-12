@extends('main')

@section('content')

    <div class="col-md-12 container">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Thêm mới kỳ học</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route'=>'admin.semesters.store', 'class'=>'form-horizontal', 'files'=>true]) !!}
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
                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Tên kỳ học</label>
                        <div class="col-sm-10">
                            {!! Form::number('semester_number', '', ['class'=>'form-control', 'placeholder'=>'Nhập tên kỳ học']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Tên năm học</label>
                        <div class="col-sm-10">
                            {!! Form::text('year', '', ['class'=>'form-control', 'placeholder'=>'Nhập tên năm học']) !!}
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    {!! Form::submit('Tạo mới', ['class'=>'btn btn-primary']) !!}
                </div><!-- /.box-footer -->
            {!! Form::close() !!}
        </div><!-- /.box -->
    </div>
@stop
