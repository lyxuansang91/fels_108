
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Register</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
            {!! HTML::style('/bootstrap/css/bootstrap.min.css') !!}
        <!-- Theme style -->
            {!! HTML::style('/dist/css/AdminLTE.min.css') !!}
        <!-- iCheck -->
            {!! HTML::style('/plugins/iCheck/square/blue.css') !!}

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <a href="../../index2.html"><b>E</b>Learning</a>
        </div>

        <div class="register-box-body">
            <p class="login-box-msg">Register a new membership</p>
             @if(count($errors) > 0)
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                    @foreach($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                </div>
            @endif
            {!! Form::open(['route'=>'user.register.store']) !!}
            <div class="form-group has-feedback">
                {!! Form::text('name', '', ['class'=>'form-control', 'placeholder'=>'Full name']) !!}
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                {!! Form::text('email', '', ['class'=>'form-control', 'placeholder'=>'Email']) !!}
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                {!! Form::password('password', ['class'=>'form-control', 'placeholder'=>'Password']) !!}
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                {!! Form::password('password_confirm', ['class'=>'form-control', 'placeholder'=>'Retype password']) !!}
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    {!! Form::submit('Register', ['class'=>'btn btn-primary btn-block btn-flat']) !!}
                </div><!-- /.col -->
            </div>
            {!! Form::close() !!}
        </div><!-- /.form-box -->
    </div><!-- /.register-box -->

    <!-- jQuery 2.1.4 -->
    {!! HTML::script('plugins/jQuery/jQuery-2.1.4.min.js') !!}
    <!-- Bootstrap 3.3.5 -->
    {!! HTML::script('/bootstrap/js/bootstrap.min.js') !!}
    <!-- iCheck -->
    {!! HTML::script('/plugins/iCheck/icheck.min.js') !!}
    </body>
</html>
