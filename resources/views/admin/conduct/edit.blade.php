@extends('main')

@section('content')

    <div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Edit User-Group</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route'=>['admin.conducts.update', $conduct->id], 'method'=>'put','class'=>'form-horizontal']) !!}
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
                        <label for="inputName3" class="col-sm-2 control-label">Conduct Name</label>
                        <div class="col-sm-10">
                            {!! Form::text('conduct_name', $conduct->conduct_name, ['class'=>'form-control', 'pladeholder'=> 'Input conduct name']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Semester Name</label>
                        <div class="col-sm-10">
                            {!! Form::select('semester_id', $semesters, $conduct->semester_id, ['class'=>'form-control', 'pladeholder'=> 'Pick a semester']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">User Name</label>
                        <div class="col-sm-10">
                            {!! Form::select('user_id', $users, $conduct->user_id, ['class'=>'form-control', 'pladeholder'=> 'Pick an User']) !!}
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    {!! Form::submit('Edit', ['class'=>'btn btn-primary']) !!}
                </div><!-- /.box-footer -->
            {!! Form::close() !!}
        </div><!-- /.box -->
    </div>
@stop
