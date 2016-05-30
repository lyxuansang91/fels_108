@extends('main')

@section('content')

    <div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Create new User-Grade</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route'=>'admin.user_grades.store', 'class'=>'form-horizontal']) !!}
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

                    <div class="form-grade">
                        <label for="inputName3" class="col-sm-2 control-label">Grade Name</label>
                        <div class="col-sm-10">
                            {!! Form::select('grade_id', $grades, null, ['class'=>'form-control', 'pladeholder'=> 'Pick a grade']) !!}
                        </div>
                    </div>

                    <div class="form-grade">
                        <label for="inputName3" class="col-sm-2 control-label">User Name</label>
                        <div class="col-sm-10">
                            {!! Form::select('user_id', $users, null, ['class'=>'form-control', 'pladeholder'=> 'Pick an User']) !!}
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
