@extends('main')

@section('content')

    <div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Edit a Subject</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route'=>['admin.subjects.update', $subject->id], 'method'=>'put', 'class'=>'form-horizontal', 'files' => true]) !!}
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
                        <label for="inputName3" class="col-sm-2 control-label">Subject</label>
                        <div class="col-sm-10">
                            {!! Form::text('subject_name', $subject->subject_name, ['class'=>'form-control', 'placeholder'=>'Input Subject']) !!}
                        </div>
                    </div>

                    @if (count($subjectGroupArray) > 0)
                        @foreach($subjectGroupArray as $subject_group)
                        <div class="form-group">
                            <label for="inputName3" class="col-sm-2 control-label">Hệ số {{{$subject_group->group->group_name}}}</label>
                            <div class="col-sm-10">
                                {!! Form::text('group_'.$subject_group->group->id, $subject_group->factor, ['class'=>'form-control', 'placeholder'=>'Input Factor']) !!}
                            </div>
                        </div>
                        @endforeach
                    @else
                        @foreach($groupArray as $group)
                            <div class="form-group">
                                <label for="inputName3" class="col-sm-2 control-label">Hệ số {{{$group->group_name}}}</label>
                                <div class="col-sm-10">
                                    {!! Form::text('group_'.$group->id, '', ['class'=>'form-control', 'placeholder'=>'Input Factor'.$group->id]) !!}
                                </div>
                            </div>
                        @endforeach
                    @endif


                </div><!-- /.box-body -->
                <div class="box-footer">
                    <a href="{!! URL::previous() !!}" class="btn  btn-default">Back</a>
                    {!! Form::submit('Update', ['class'=>'btn btn-primary pull-right']) !!}
                </div><!-- /.box-footer -->
            {!! Form::close() !!}
        </div><!-- /.box -->
    </div>
@stop
