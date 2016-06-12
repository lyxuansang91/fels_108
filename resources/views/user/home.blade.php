@extends('user.main')

@section('content')
<div class="content-wrapper" style="min-height: 449px;">
    <div class="container">
        <div class="col-md-12">
            <div class="box">
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i>Trang chủ</li>
                </ol>
                <div class="row">
                    <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3>{!! $users->count() !!}</h3>
                                <p>Người dùng</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person"></i>
                            </div>
                            <a href="{!! route('user.list.index') !!}" class="small-box-footer">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div><!-- ./col -->
                </div><!-- /.row -->
            </div>
        </div>
    </div>
      <!-- Main row -->
</div> <!-- /.content -->
@stop