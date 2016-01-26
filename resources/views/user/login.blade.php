
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Elearning | Log in</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        {!! HTML::style('bootstrap/css/bootstrap.min.css') !!}
        <!-- Theme style -->
        {!! HTML::style('dist/css/AdminLTE.min.css') !!}
        <!-- iCheck -->
        {!! HTML::style('plugins/iCheck/square/blue.css') !!}

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="{!! route('user.index') !!}"><b>Elearning</b>System</a>
            </div><!-- /.login-logo -->
            <div class="login-box-body">
                @if(count($errors) > 0)
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        @foreach($errors->all() as $error)
                            <li>{!! $error !!}</li>
                        @endforeach
                    </div>
                @endif
                
                @if(Session::has('messages'))
                    <div class="alert alert-warning alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        {!! Session::get('messages') !!}
                    </div>
                @endif
                <p class="login-box-msg">Sign in to start your session</p>
                {!! Form::open(['route'=>'user.login.store']) !!}
                    <div class="form-group has-feedback">
                        {!! Form::text('email', '', ['class'=>'form-control', 'placeholder'=>'Email']) !!}
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::password('password', ['class'=>'form-control', 'placeholder'=>'Password']) !!}
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            {!! Form::submit('Sign In', ['class'=>'btn btn-primary btn-block btn-flat']) !!}
                        </div><!-- /.col -->
                    </div>
                    <a href="{!! route('user.profile.create') !!}" class="text-center">Register a new membership</a>
                {!! Form::close() !!}
            </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    {!! HTML::script('plugins/jQuery/jQuery-2.1.4.min.js') !!}
    <!-- Bootstrap 3.3.5 -->
    {!! HTML::script('bootstrap/js/bootstrap.min.js') !!}
    <!-- iCheck -->
    {!! HTML::script('plugins/iCheck/icheck.min.js') !!}
  </body>
</html>
