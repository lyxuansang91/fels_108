@extends('main')

@section('content')

    <div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Word</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route'=>['admin.words.update', $word->id], 'method'=>'put','class'=>'form-horizontal']) !!}
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
                    @if(session()->has('messages'))
                        <div class="alert alert-warning alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                            {!! session('messages') !!}
                        </div>
                    @endif
                    <div class="col-xs-4">
                        {!! Form::select('category', $categoryArray, $word->category_id, ['class'=>'form-control']) !!}
                    </div>
                    <div class="col-xs-4">
                        {!! Form::text('word', $word->word, ['class'=>'form-control', 'placeholder'=>'Word']) !!}
                    </div>
                    <div class="col-xs-4">
                        {!! Form::text('trans_word', $word->transWord->trans_word, ['class'=>'form-control', 'placeholder'=>'Translate word']) !!}
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    {!! Form::submit('Edit word', ['class'=>'btn btn-primary']) !!}
                </div><!-- /.box-footer -->
            {!! Form::close() !!}
        </div><!-- /.box -->
    </div>
@stop