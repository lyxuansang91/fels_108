@extends('main')

@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
          	<h1>
	            Home
	            <small>Control panel</small>
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
                  			<h3>{!! count($users) !!}</h3>
                  			<p>Total Users</p>
                		</div>
                		<div class="icon">
                  			<i class="ion ion-person"></i>
                		</div>
                		<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              		</div>
            	</div><!-- ./col -->
            	<div class="col-lg-3 col-xs-6">
              		<!-- small box -->
              		<div class="small-box bg-green">
                		<div class="inner">
                  			<h3>{!! count($words) !!}</h3>
                  			<p>Total Words</p>
                		</div>
                		<div class="icon">
                  			<i class="ion ion-stats-bars"></i>
                		</div>
                		<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              		</div>
            	</div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              	<!-- small box -->
              	<div class="small-box bg-yellow">
                	<div class="inner">
                  		<h3>{!! count($categories) !!}</h3>
                  		<p>Total Categories</p>
                	</div>
                	<div class="icon">
                  		<i class="ion ion-bag"></i>
                	</div>
                	<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              	</div>
            </div><!-- ./col -->
          </div><!-- /.row -->
          <!-- Main row -->
        </section><!-- /.content -->
@stop