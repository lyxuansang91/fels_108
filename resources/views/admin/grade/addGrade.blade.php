@extends('main')

@section('content')

    <div class="col-md-12 container">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Thêm mới khối học</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route'=>'admin.grades.store', 'class'=>'form-horizontal', 'files'=>true]) !!}
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
                        <label for="inputName3" class="col-sm-2 control-label">Tên khối học</label>
                        <div class="col-sm-10">
                            {!! Form::text('grade_name', '', ['class'=>'form-control', 'placeholder'=>'Nhập tên khối']) !!}
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-10">
                            {!! Form::file('image', '', ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Content</label>
                        <div class="col-sm-10">
                            {!! Form::textArea('content', '', ['class'=>'form-control']) !!}
                        </div>
                    </div> -->
                </div><!-- /.box-body -->
                <div class="box-footer">
                    {!! Form::submit('Tạo mới', ['class'=>'btn btn-primary']) !!}
                </div><!-- /.box-footer -->
            {!! Form::close() !!}
        </div><!-- /.box -->
    </div>
@stop
