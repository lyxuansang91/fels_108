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
                        <li><a href="{!! route('user.lessons.show', $lesson->id) !!}"> Lesson</a></li>
                        <li class="active">Result</li>
                    </ol>
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Result</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                                <!-- radio -->
                            @if($lesson->isPassed())
                                <div class="form-group has-success">
                                    <label class="control-label" for="inputSuccess"><i class="fa fa-check"></i>
                                        Lesson result : {!! $result->count() . '/' . $lesson->lessonWords->count() !!}
                                    </label>
                                </div>
                            @else
                                <div class="form-group has-error">
                                    <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>
                                        Lesson result : {!! $result->count() . '/' . $lesson->lessonWords->count() !!}
                                    </label>
                                </div>
                            @endif
                            <div class="form-group">
                                    @foreach($lesson->lessonWords as $key => $lessonWord)
                                    <label>{!! $key + 1 . '.' . $lessonWord->word->word !!}</label>
                                    @if($lessonWord->isCorrectAnswer())
                                            <label class="control-label " for="inputSuccess"><i class="fa fa-check" style="color:#00a65a;" ></i></label>
                                    @else
                                            <label class="control-label" for="inputError"><i class="fa fa-times-circle-o" style="color:#dd4b39;"></i></label>
                                    @endif
                                    @foreach($answerArray as $answer)
                                    <div class="radio">                                        
                                        <label>
                                            @if($lessonWord->choosed == $lessonWord->$answer)
                                                {!! Form::radio('question' . ($key + 1), $lessonWord->$answer, true) !!}
                                            @else
                                                {!! Form::radio('question' . ($key + 1), $lessonWord->$answer) !!}
                                            @endif
                                                {!! $lessonWord->$answer !!}
                                        </label>
                                    </div>
                                    @endforeach
                                @endforeach
                                <div class="box-footer">
                                    <a href="{!! URL::previous() !!}" class="btn  btn-default">Back</a>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                    </div>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
</div>
@stop