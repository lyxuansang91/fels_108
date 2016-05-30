@extends('main')

@section('content')

    <div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Create new user point</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route'=>'admin.points.store', 'class'=>'form-horizontal']) !!}
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
                        <label for="inputName3" class="col-sm-2 control-label">Grade</label>
                        <div class="col-sm-10">
                            {!! Form::select('user_id', $users, null,  ['class'=>'form-control', 'pladeholder'=> 'Pick a grade']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Grade</label>
                        <div class="col-sm-10">
                            {!! Form::select('semester_subject_group_id', $semester_subject_groups, null,  ['class'=>'form-control', 'pladeholder'=> 'Pick a grade']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Mark m1</label>
                        <div class="col-sm-10">
                            {!! Form::text('mark_m1', '', ['class'=>'form-control', 'placeholder'=>'Input Mark m1']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Mark m2</label>
                        <div class="col-sm-10">
                            {!! Form::text('mark_m2', '', ['class'=>'form-control', 'placeholder'=>'Input Mark m2']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Mark m3</label>
                        <div class="col-sm-10">
                            {!! Form::text('mark_m3', '', ['class'=>'form-control', 'placeholder'=>'Input Mark m3']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Mark m4</label>
                        <div class="col-sm-10">
                            {!! Form::text('mark_m4', '', ['class'=>'form-control', 'placeholder'=>'Input Mark m4']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Mark 15 1</label>
                        <div class="col-sm-10">
                            {!! Form::text('mark_15_1', '', ['class'=>'form-control', 'placeholder'=>'Input Mark 15 1']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Mark 15 2</label>
                        <div class="col-sm-10">
                            {!! Form::text('mark_15_2', '', ['class'=>'form-control', 'placeholder'=>'Input mark_15_2']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Mark 15 3</label>
                        <div class="col-sm-10">
                            {!! Form::text('mark_15_3', '', ['class'=>'form-control', 'placeholder'=>'Input mark_15_3']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Mark 45 1</label>
                        <div class="col-sm-10">
                            {!! Form::text('mark_45_1', '', ['class'=>'form-control', 'placeholder'=>'Input mark_45_1']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Mark 45 2</label>
                        <div class="col-sm-10">
                            {!! Form::text('mark_45_2', '', ['class'=>'form-control', 'placeholder'=>'Input mark_45_2']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Mark last</label>
                        <div class="col-sm-10">
                            {!! Form::text('mark_last', '', ['class'=>'form-control', 'placeholder'=>'Input mark_last']) !!}
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
