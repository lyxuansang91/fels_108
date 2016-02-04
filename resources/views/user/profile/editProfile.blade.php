@extends('user.main')

@section('content')

    <div class="container">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <ol class="breadcrumb">
                    <li><a href="{!! route('user.index') !!}"><i class="fa fa-home"></i> Home</a></li>
                    <li><a href="{!! route('user.profiles.show', \Auth::id()) !!}">Profile</a></li>
                    <li class="active">Update Profile</li>
                </ol>
                <div class="box-header with-border">
                    <h2 class="box-title">Update profile</h2>
                </div><!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['route'=>['user.profiles.update', $user->id], 'method'=>'put', 'class'=>'form-horizontal', 'files'=>true]) !!}
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
                            <label for="inputEmail3" class="col-sm-2 control-label">Avatar</label>
                            <div class="col-sm-10">
                                <span> {!! HTML::image($user->avatar, 'User avatar', ['style'=>'width: 100%; max-width: 150px; height: 150px;']) !!} </span>
                                {!! Form::file('avatar', '', ['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                {!! Form::text('email', $user->email, ['class'=>'form-control', 'placeholder'=>'Email']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName3" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                {!! Form::text('name', $user->name, ['class'=>'form-control', 'placeholder'=>'Input name']) !!}
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <a href="{!! URL::previous() !!}" class="btn  btn-default">Back</a>
                        {!! Form::submit('Submit', ['class'=>'btn btn-primary pull-right']) !!}
                    </div><!-- /.box-footer -->
                {!! Form::close() !!}
            </div><!-- /.box -->
        </div>
          <!-- Main content -->
          <section class="content">

          </section><!-- /.content -->
    </div>
@stop