@extends('user.main')

@section('content')
<div class="container">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <ol class="breadcrumb">
                        <li><a href="{!! route('user.index') !!}"><i class="fa fa-home"></i> Home</a></li>
                        <li><a href="{!! route('user.categories.index') !!}"> Categories</a></li>
                        <li class="active">lesson</li>
                    </ol>
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Lesson</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            {!! Form::open(['route' => ['user.lessons.update', $lesson->id], 'method' => 'PUT']) !!}
                                <!-- radio -->
                                What is the correct word?
                                <div class="form-group">
                                    @foreach($lesson->lessonWords as $key => $lessonWord)
                                        <label>{!! $key + 1 . '.' . $lessonWord->word->word !!}</label>
                                        @foreach($answerArray as $answer)
                                            <div class="radio">
                                                <label>
                                                    {!! Form::radio('question' . ($key + 1), $lessonWord->$answer) !!}
                                                    {!! $lessonWord->$answer !!}
                                                </label>
                                            </div>
                                        @endforeach
                                    @endforeach
                                    <div class="box-footer">
                                        <a href="{!! URL::previous() !!}" class="btn  btn-default">Back</a>
                                        {!! Form::submit('Result', ['class' => 'btn btn-info pull-right']) !!}
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div><!-- /.box-body -->
                    </div>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
</div>
@stop