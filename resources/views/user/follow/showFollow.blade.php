@extends('user.main')
@section('content')
<div class="container">
    <div class="col-md-12">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <ol class="breadcrumb">
                        <li><a href="{!! route('user.index') !!}"><i class="fa fa-home"></i> Home</a></li>
                        <li><a href="{!! route('user.profiles.show', $user->id) !!}"> Profiles</a></li>
                        <li class="active">Follow</li>
                    </ol>
                    
                    {!! Form::open(['route'=>['user.follows.show', $user->id], 'method'=>'GET', 'class'=>'form-horizontal']) !!}
                    <div class="form-group">
                        <div class="input-group input-group-sm col-sm-3 pull-right">
                        {!! Form::text('search', '', ['class'=>'form-control', 'placeholder'=>'search member']) !!}
                            <span class="input-group-btn">
                                {!! Form::submit('search', ['class'=>'btn btn-default btn-flat', 'name'=>'submit', 'style'=>'margin-right: 30px;']) !!}
                            </span>
                        </div>
                    </div>
                        <div class="box-footer">
                        </div><!-- /.box-footer -->
                    {!! Form::close() !!}
                    <div class="box-header">
                        <h3 class="box-title">Following</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($followings as $following)
                                <tr>
                                    <td>
                                        <a href="{!! route('user.profiles.show', $following->followee->id) !!}">{!! $following->followee->name !!}</a>
                                    </td>
                                    <td>{!! $following->followee->email !!}</td>
                                    <td>{!! $following->created_at !!}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->

                    <div class="box-header">
                        <h3 class="box-title">Followed</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example3" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($followeds as $followed)
                                <tr>
                                    <td>
                                        <a href="{!! route('user.profiles.show', $followed->follower->id) !!}">{!! $followed->follower->name !!}</a>
                                    </td>
                                    <td>{!! $followed->follower->email !!}</td>
                                    <td>{!! $followed->created_at !!}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->

                </div><!-- /.box -->
            </div><!-- /.col -->
            
        </div><!-- /.row -->
    </div>
</div>
@stop
@section('script')
    {!! HTML::script('/plugins/datatables/jquery.dataTables.min.js') !!}
    {!! HTML::script('/plugins/datatables/dataTables.bootstrap.min.js') !!}
    <script>
      $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
        $('#example3').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
    </script>
@stop
