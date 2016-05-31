@extends('main')

@section('content')

    <div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Create new Student</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route'=>'admin.students.store', 'class'=>'form-horizontal']) !!}
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
                        <label for="inputName3" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            {!! Form::text('name', '', ['class'=>'form-control', 'placeholder'=>'Input name']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Gender</label>
                        <div class="col-sm-10">
                            {!! Form::select('gender',['Nam', 'Nữ'], null, ['class'=>'form-control', 'placeholder'=>'Input Gender']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Birthday</label>
                        <div class="col-sm-10">
                            {!! Form::date('birthday', \Carbon\Carbon::now(), ['class'=>'form-control', 'placeholder'=>'Input Birthday']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-10">
                            {!! Form::text('address', '', ['class'=>'form-control', 'placeholder'=> 'Input address']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Phone</label>
                        <div class="col-sm-10">
                            {!! Form::text('phone', '', ['class'=>'form-control', 'placeholder'=> 'Input phone']) !!}
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    {!! Form::submit('Create', ['class'=>'btn btn-primary']) !!}
                </div><!-- /.box-footer -->
            {!! Form::close() !!}
        </div><!-- /.box -->
    </div>
@stop
