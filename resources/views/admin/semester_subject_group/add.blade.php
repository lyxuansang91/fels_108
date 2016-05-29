@extends('main')

@section('content')

    <div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Create new Semester-Subject-Group</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route'=>'admin.semester_subject_groups.store', 'class'=>'form-horizontal']) !!}
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
                        <label for="inputName3" class="col-sm-2 control-label">Semester Name</label>
                        <div class="col-sm-10">
                            {!! Form::select('semester_id', $semesters, null, ['class'=>'form-control', 'pladeholder'=> 'Pick a Semester']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Subject Name</label>
                        <div class="col-sm-10">
                            {!! Form::select('subject_id', $subjects, null, ['class'=>'form-control', 'pladeholder'=> 'Pick a Subject']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Group Name</label>
                        <div class="col-sm-10">
                            {!! Form::select('group_id', $groups, null, ['class'=>'form-control', 'pladeholder'=> 'Pick a Group']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Level Name</label>
                        <div class="col-sm-10">
                            {!! Form::select('level_id', $levels, null, ['class'=>'form-control', 'pladeholder'=> 'Pick a Level']) !!}
                        </div>
                    </div>

                    <div class="form-group">
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
