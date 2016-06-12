@extends('main')

@section('content')

    <div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Chỉnh sửa kỳ học</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route'=>['admin.semesters.update', $semester->id], 'method'=>'put', 'class'=>'form-horizontal', 'files' => true]) !!}
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
                            {!! Form::number('semester_number', $semester->semester_number, ['class'=>'form-control', 'placeholder'=>'Nhập tên kỳ học']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Tên năm học</label>
                        <div class="col-sm-10">
                            {!! Form::text('year', $semester->year, ['class'=>'form-control', 'placeholder'=>'Nhập tên năm học']) !!}
                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <a href="{!! URL::previous() !!}" class="btn  btn-default"><<</a>
                    {!! Form::submit('Cập nhật', ['class'=>'btn btn-primary pull-right']) !!}
                </div><!-- /.box-footer -->
            {!! Form::close() !!}
        </div><!-- /.box -->
    </div>
@stop
