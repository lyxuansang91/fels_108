@extends('main')

@section('content')

    <div class="col-md-12 container">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Create new semester</h3>
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
                        <label for="inputName3" class="col-sm-2 control-label">Semester Number</label>
                        <div class="col-sm-10">
                            {!! Form::number('semester_number', '', ['class'=>'form-control', 'placeholder'=>'Input Semester']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Year</label>
                        <div class="col-sm-10">
                            {!! Form::number('year', '', ['class'=>'form-control', 'placeholder'=>'Input Year']) !!}
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
                    {!! Form::submit('Create', ['class'=>'btn btn-primary']) !!}
                </div><!-- /.box-footer -->
            {!! Form::close() !!}
        </div><!-- /.box -->
    </div>
@stop
