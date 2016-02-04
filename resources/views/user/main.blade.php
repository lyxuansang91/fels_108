
  <!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Framgia E-Learning System</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
            {!! HTML::style('/bootstrap/css/bootstrap.min.css') !!}
        <!-- Font Awesome -->
            {{-- {!! HTML::style('/font/font-awesome.min.css') !!} --}}
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Ionicons -->
            {!! HTML::style('/ionicons/ionicons.min.css') !!}
            {{-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> --}}
            {{-- <link rel="stylesheet" href="/ionicons/ionicons.min.css"> --}}

            {!! HTML::style('/plugins/datatables/dataTables.bootstrap.css') !!}
        <!-- Theme style -->
            {!! HTML::style('/dist/css/AdminLTE.min.css') !!}
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
            {!! HTML::style('/dist/css/skins/_all-skins.min.css') !!}

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
    <body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">

    <header class="main-header">
        <nav class="navbar navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <a href="{!! route('user.index') !!}" class="navbar-brand"><b>E</b>Learning</a>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="{!! route('user.categories.index') !!}">Categories</a></li>
                        <li><a href="{!! route('user.words.index') !!}">Words</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="{!! auth()->user()->avatar !!}" class="user-image" alt="User Image">
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{!! auth()->user()->name !!}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="{!! auth()->user()->avatar !!}" class="img-circle" alt="User Image">
                                    <p>{!! auth()->user()->name !!}</p>
                                </li>
                                <!-- Menu Body -->
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{!! route('user.profiles.show', \Auth::id()) !!}" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{!! route('user.logout.index') !!}" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-custom-menu -->
            </div><!-- /.container-fluid -->
        </nav>
    </header>
    <!-- Full Width Column -->
    <div class="content-wrapper">
        @yield('content')
    </div><!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="container">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.0
            </div>
            <strong>Copyright &copy; 2015-2016 <a href="{!! route('user.index') !!}">Framgia Elearning System</a>.</strong> All rights reserved.
        </div><!-- /.container -->
    </footer>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    {!! HTML::script('plugins/jQuery/jQuery-2.1.4.min.js') !!}
    <!-- Bootstrap 3.3.5 -->
    {!! HTML::script('/bootstrap/js/bootstrap.min.js') !!}
    <!-- SlimScroll -->
    {!! HTML::script('/plugins/slimScroll/jquery.slimscroll.min.js') !!}
    <!-- FastClick -->
    {!! HTML::script('/plugins/fastclick/fastclick.min.js') !!}
    <!-- AdminLTE App -->
    {!! HTML::script('/dist/js/app.min.js') !!}
    <!-- AdminLTE for demo purposes -->
    {!! HTML::script('/dist/js/demo.js') !!}
  </body>
</html>
