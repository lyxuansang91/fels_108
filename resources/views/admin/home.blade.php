@extends('main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      	<h1>
            Trang chủ
            <small></small>
      	</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      	<!-- Small boxes (Stat box) -->
      	<div class="row">
        	<div class="col-lg-3 col-xs-6">
          	<!-- small box -->
          		<div class="small-box bg-aqua">
            		<div class="inner">
              			<h3>{!! $users->count() !!}</h3>
              			<p>người dùng</p>
            		</div>
            		<div class="icon">
              			<i class="ion ion-person"></i>
            		</div>
            		<a href="#" class="small-box-footer">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
          		</div>
        	</div><!-- ./col -->
      </div><!-- /.row -->
      <!-- Main row -->
    </section><!-- /.content -->
@stop