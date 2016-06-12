@extends('main')

@section('content')

    <div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Tạo mới người dùng</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route'=>'admin.members.store', 'class'=>'form-horizontal']) !!}
                <div class="box-body">
                    @if(count($errors) > 0)
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Vui lòng nhập đầy đủ thông tin yêu cầu!</h4>
                        @foreach($errors->all() as $error)
                            <li>{!! $error !!}</li>
                        @endforeach
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            {!! Form::text('email', '', ['class'=>'form-control', 'placeholder'=>'Email']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Tên đăng nhập</label>
                        <div class="col-sm-10">
                            {!! Form::text('name', '', ['class'=>'form-control', 'placeholder'=>'Tên đăng nhập']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Mật khẩu</label>
                        <div class="col-sm-10">
                            {!! Form::password('password', ['class'=>'form-control', 'placeholder'=>'Nhập mật khẩu']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Xác nhận mật khẩu</label>
                        <div class="col-sm-10">
                            {!! Form::password('password_confirm', ['class'=>'form-control', 'placeholder'=>'Xác nhận mật khẩu']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Role</label>
                        <div class="col-sm-10">
                            {!! Form::select('role', get_roles_array(), \App\Models\User::ROLE_USER, ['class'=>'form-control']) !!}
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    {!! Form::submit('Tạo mới', ['class'=>'btn btn-primary']) !!}
                </div><!-- /.box-footer -->
            {!! Form::close() !!}
        </div><!-- /.box -->
    </div>
@stop