@extends('main')

@section('content')

    <div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Thêm mới giáo viên</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route'=>'admin.teachers.store', 'class'=>'form-horizontal', 'files' => true]) !!}
                <div class="box-body">
                    @if(count($errors) > 0)
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Vui lòng nhập đầy đủ thông tin!</h4>
                        @foreach($errors->all() as $error)
                            <li>{!! $error !!}</li>
                        @endforeach
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Họ và tên</label>
                        <div class="col-sm-10">
                            {!! Form::text('teacher_name', '', ['class'=>'form-control', 'placeholder'=>'Mời nhập họ và tên giáo viên']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Giới tính</label>
                        <div class="col-sm-10">
                            {!! Form::select('gender',['Nam', 'Nữ'], null, ['class'=>'form-control', 'placeholder'=>'Chọn giới tính']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Ngày sinh</label>
                        <div class="col-sm-10">
                            {!! Form::date('birthday', \Carbon\Carbon::now(), ['class'=>'form-control', 'placeholder'=>'Ngày sinh']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Địa chỉ</label>
                        <div class="col-sm-10">
                            {!! Form::text('address', '', ['class'=>'form-control', 'placeholder'=> 'Nhập địa chỉ']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Số điện thoại</label>
                        <div class="col-sm-10">
                            {!! Form::text('phone', '', ['class'=>'form-control', 'placeholder'=> 'Nhập số điện thoại']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Môn học</label>
                        <div class="col-sm-10">
                            {!! Form::select('subject_id', $subjectArray, NULL, ['class'=>'form-control', 'placeholder'=> 'Chọn môn học']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Ảnh đại diện</label>
                        <div class="col-sm-10">
                            {!! Form::file('image', '', ['class'=>'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Trình độ</label>
                        <div class="col-sm-10">
                            {!! Form::text('experiences', '', ['class'=>'form-control', 'placeholder' => 'Nhập trình độ']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            {!! Form::text('email', '', ['class'=>'form-control', 'placeholder'=> 'Nhập Email']) !!}
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
