@extends('user.main')

@section('content')
    {{-- <section class="content"> --}}
    <div class="container">
        <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <ol class="breadcrumb">
                        <li><a href="{!! route('user.index') !!}"><i class="fa fa-home"></i> Trang chủ</a></li>
                        <li><a href="{!! route('user.profiles.show', auth()->id()) !!}"> Thông tin</a></li>
                        <li class="active">List learned</li>
                    </ol>
                    <div class="box-header">
                        <h3 class="box-title">List Word</h3>
                    </div><!-- /.box-header -->

                    {!! Form::open(['route'=>'user.learned-words.store', 'class'=>'form-horizontal']) !!}
                        {!! Form::hidden('id', $id) !!}
                    <div class="form-group">
                        <div class="input-group input-group-sm col-sm-3 pull-right">
                        {!! Form::text('search', '', ['class'=>'form-control', 'placeholder'=>'search word']) !!}
                            <span class="input-group-btn">
                                {!! Form::submit('search', ['class'=>'btn btn-default btn-flat', 'name'=>'submit', 'style'=>'margin-right: 30px;']) !!}
                            </span>
                        </div>
                    </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Category</label>
                                <div class="col-sm-4">
                                    {!! Form::select('category_id', $categoryArray, isset($data['category_id']) ? $data['category_id'] : '', ['class'=>'form-control', 'onchange'=>"showDiv(this)"]) !!}
                                </div>
                                <div class="col-sm-1">
                                    {!! Form::submit('Filter', ['class' => 'btn btn-default']) !!}
                                </div>
                            </div>
                            {!! $learnedWords->appends($data)->render() !!}
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                        </div><!-- /.box-footer -->
                    {!! Form::close() !!}

                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            @if($learnedWords->count() > 0)
                                <thead>
                                    <tr>
                                        <th>Japanese</th>
                                        <th>VietNamese</th>
                                        <th>Lesson's history</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($learnedWords as $learnedWord)
                                        <tr>
                                            <td>{{{ $learnedWord->word }}}</td>
                                            <td>{{{ $learnedWord->transWord->trans_word }}}</td>
                                            <td>
                                                @foreach($learnedWord->lessonWords as $lesson)
                                                    <a href="{!! route('user.results.show', $lesson->lesson_id) !!}"> {{ $lesson->lesson_id }}</a>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @else
                                List Word is empty
                            @endif
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div>
    </div>
    {{-- </section>/.content --}}
    {!! HTML::script('/myJs/showWord.js') !!}
@stop