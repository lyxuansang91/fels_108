@extends('user.main')

@section('content')
<div class="container">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <ol class="breadcrumb">
                        <li><a href="{!! route('user.index') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">List categories</li>
                    </ol>
                    <div class="box-header">
                        <h3 class="box-title">List Categories</h3>
                    </div><!-- /.box-header -->
                    @if(session()->has('messages'))
                        <div class="alert alert-warning alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                            {!! session('messages') !!}
                        </div>
                    @endif
                    <div class="box box-widget">
                        <div class="box-body">
                            <!-- Attachment -->
                            @foreach($categories as $category)
                            <div class="attachment-block clearfix">
                                <img class="attachment-img" src="../dist/img/photo1.png" alt="attachment image">
                                <div class="attachment-pushed">
                                    <h4 class="attachment-heading"><a href="#">{{ $category->name }}</a>  You've learned 20/500 </h4>
                                    <div class="attachment-text">
                                        {!! nl2br($category->content) !!}
                                    </div><!-- /.attachment-text -->
                                </div><!-- /.attachment-pushed -->
                                {!! Form::open(['route' => 'user.lessons.store']) !!}
                                    <button class="btn btn-default btn-xs" type="submit"><i class="fa fa-share"></i>Start lesson</button>
                                    {!! Form::hidden('category_id', $category->id) !!}
                                    {!! Form::hidden('user_id', \Auth::id()) !!}
                                {!! Form::close() !!}
                            </div><!-- /.attachment-block -->
                            @endforeach
                        </div><!-- /.box-body -->
                    </div>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
</div>
@stop