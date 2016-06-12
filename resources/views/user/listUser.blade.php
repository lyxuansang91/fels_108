@extends('user.main')

@section('content')
    {{-- <section class="content"> --}}
    <div class="container">
        <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <ol class="breadcrumb">
                        <li><a href="{!! route('user.index') !!}"><i class="fa fa-home"></i> Trang chủ</li>
                        <li class="active">List Member</li>
                    </ol>
                    <div class="box-header">
                        <h3 class="box-title">List Member</h3>
                    </div><!-- /.box-header -->

                    {!! Form::open(['route'=>'user.list.index', 'method'=>'GET', 'class'=>'form-horizontal']) !!}
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

                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            @if($users->count() > 0)
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td><a href="{!! route('user.profiles.show', $user->id) !!}"> {!! $user->name !!} </a> </td>
                                            <td>{{{ $user->email }}}</td>
                                            <td>
                                                @if ($user->follows->count() < 1)
                                                    Not Follow
                                                @else
                                                    Following
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                {!! $users->render() !!}
                            @else
                                Danh sách người dùng trống.
                            @endif
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div>
    </div>
    {{-- </section>/.content --}}
    {!! HTML::script('/myJs/showWord.js') !!}
@stop