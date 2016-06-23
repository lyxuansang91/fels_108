
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sổ liên lạc điện tử</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
        {!! HTML::style('/bootstrap/css/bootstrap.min.css') !!}
    <!-- Font Awesome -->
        {{-- {!! HTML::style('/font/font.min.css') !!} --}}
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
        {{-- {!! HTML::style('/ionicons/ionicons.min.css') !!} --}}
         <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
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
    <!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
    <!-- the fixed layout is not compatible with sidebar-mini -->
  <body class="hold-transition skin-blue fixed sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="{!! route('admin.index') !!}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">THPT B Kim Bảng</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">THPT B Kim Bảng</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="{!! Asset('images/avatar/default.png') !!}" class="user-image" alt="User Image">
                  <span class="hidden-xs">{!! auth()->user()->email !!}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="{!!Asset('images/avatar/default.png') !!}" class="img-circle" alt="User Image">
                    <p>
                      {!! auth()->user()->email !!}
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Thông tin</a>
                    </div>
                    <div class="pull-right">
                      <a href="{!! route('admin.logout.index') !!}" class="btn btn-default btn-flat">Đăng xuất</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>

      <!-- =============================================== -->

      <!-- Left side column. contains the sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="{!! Asset('images/avatar/default.png') !!}" class="img-circle" alt="User Image" style="width: 100%;">
            </div>
            <div class="pull-left info">
              <p>{!! Auth()->user()->email !!}</p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Tìm kiếm...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li>
              <a href="{!! route('admin.index') !!}">
                <i class="fa fa-home"></i> <span>Trang chủ</span>
              </a>
            </li>
            <li class="treeview active">
              <a href="#">
                <i class="fa fa-gg"></i>
                <span>Quản lý DM</span>
              </a>
              <ul class="treeview-menu">
                @if (auth()->user()->role != \App\Models\User::ROLE_TEACHER) <li><a href="{!! route('admin.grades.index') !!}"><i class="fa fa-circle-o"></i> Khối </a></li> @endif
                @if (auth()->user()->role != \App\Models\User::ROLE_TEACHER) <li><a href="{!! route('admin.semesters.index') !!}"><i class="fa fa-circle-o"></i> Học kỳ</a></li> @endif
                @if (auth()->user()->role != \App\Models\User::ROLE_TEACHER) <li><a href="{!! route('admin.subjects.index') !!}"><i class="fa fa-circle-o"></i> Môn học</a></li> @endif
                @if (auth()->user()->role != \App\Models\User::ROLE_TEACHER) <li><a href="{!! route('admin.groups.index') !!}"><i class="fa fa-circle-o"></i> Ban</a></li> @endif
                @if (auth()->user()->role != \App\Models\User::ROLE_TEACHER) <li><a href="{!! route('admin.levels.index') !!}"><i class="fa fa-circle-o"></i> Lớp</a></li> @endif
              </ul>
            </li>


           <li class="treeview active">
              <a href="#">
                <i class="fa fa-gg"></i>
                <span>Quản lý GV</span>
              </a>
              <ul class="treeview-menu">
                @if (auth()->user()->role != \App\Models\User::ROLE_TEACHER) <li><a href="{!! route('admin.teachers.index') !!}"><i class="fa fa-circle-o"></i> Giáo viên</a></li> @endif
                <li><a href="{{ route('admin.teacher_subjects') }}"><i class="fa fa-circle-o"></i>Lịch dạy giáo viên</a></li>
              </ul>
            </li>


            <li class="treeview active">
              <a href="#">
                <i class="fa fa-gg"></i>
                <span>Quản lý HS</span>
              </a>
              <ul class="treeview-menu">
                @if (auth()->user()->role != \App\Models\User::ROLE_TEACHER) <li><a href="{!! route('admin.students.index') !!}"><i class="fa fa-circle-o"></i>Thông tin học sinh</a></li> @endif
                <li><a href="{{ route('admin.fees') }}"><i class="fa fa-circle-o"></i>Học phí</a></li>
              </ul>
            </li>

            <li class="treeview active">
              <a href="#">
                <i class="fa fa-gg"></i>
                <span>Quản lý KQ</span>
              </a>
              <ul class="treeview-menu">
                <li><a href="{!! route('admin.points.index') !!}"><i class="fa fa-circle-o"></i> Điểm</a></li>
                <li><a href="{!! route('admin.conducts.index') !!}"><i class="fa fa-circle-o"></i> Hạnh kiểm</a></li>
                <li><a href="{!! route('admin.semester_classes') !!}"><i class="fa fa-circle-o"></i> Tổng kết kỳ</a></li>
                <li><a href="{!! route('admin.year_classes') !!}"><i class="fa fa-circle-o"></i> Tổng kết năm</a></li>
                <li><a href="{!! route('admin.absences.index') !!}"><i class="fa fa-circle-o"></i>Chuyên cần</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i>Xét lên lớp</a></li>
                <li><a href="{!! route('admin.messages.index') !!}"><i class="fa fa-circle-o"></i>Thông tin tin nhắn HS</a></li>
              </ul>
            </li>


            <li class="treeview active">
              <a href="#">
                <i class="fa fa-gg"></i>
                <span>Báo cáo</span>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{ route('admin.report.getReport') }}"><i class="fa fa-circle-o"></i>Báo cáo kết quả học tập</a></li>
                <li><a href="{{ route('admin.report.getConduct') }}"><i class="fa fa-circle-o"></i> Báo cáo kết quả hạnh kiểm</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Báo cáo chung</a></li>
              </ul>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        @yield('content')
      </div><!-- /.content-wrapper -->

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0
        </div>
        <!-- <strong>Copyright &copy; 2016 <a href="http://almsaeedstudio.com">Framgia E-learning System</a>.</strong> All rights reserved. -->
      </footer>

      <!-- Control Sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
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
