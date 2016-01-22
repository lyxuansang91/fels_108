@extends('main')

@section('content')

    <div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Create new Category</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route'=>['admin.categories.update', $category->id], 'method'=>'put', 'class'=>'form-horizontal']) !!}
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
                        <label for="inputName3" class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-10">
                            {!! Form::text('name', $category->name, ['class'=>'form-control', 'placeholder'=>'Input Category']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Content</label>
                        <div class="col-sm-10">
                            {!! Form::textArea('content', $category->content, ['class'=>'form-control']) !!}
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <a href="{!! URL::previous() !!}" class="btn  btn-default">Back</a>
                    {!! Form::submit('Update', ['class'=>'btn btn-primary pull-right']) !!}
                </div><!-- /.box-footer -->
            {!! Form::close() !!}
        </div><!-- /.box -->
    </div>
@stop