@extends('main')

@section('content')

    <div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Sửa thông tin giáo viên</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route'=>['admin.teachers.update', $teacher->id], 'method'=>'put', 'class'=>'form-horizontal', 'files' => true]) !!}
                <div class="box-body">
                    @if(count($errors) > 0)
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Điền đầy đủ thông tin trước khi chỉnh sửa!</h4>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{!! $error !!}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Họ và tên</label>
                        <div class="col-sm-10">
                            {!! Form::text('teacher_name', $teacher->teacher_name, ['class'=>'form-control', 'placeholder'=>'Nhập họ và tên']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Giới tính</label>
                        <div class="col-sm-10">
                            {!! Form::select('gender', ['Nam', 'Nữ'], $teacher->gender, ['class'=>'form-control', 'placeholder'=>'Chọn giới tính']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Ngày sinh</label>
                        <div class="col-sm-10">
                            {!! Form::date('birthday', $teacher->birthday, ['class'=>'form-control', 'placeholder'=>'Nhập ngày sinh']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Địa chỉ</label>
                        <div class="col-sm-10">
                            {!! Form::text('address', $teacher->address, ['class'=>'form-control', 'placeholder'=> 'Nhập địa chỉ']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Số điện thoại</label>
                        <div class="col-sm-10">
                            {!! Form::text('phone', $teacher->phone, ['class'=>'form-control', 'placeholder'=> 'Nhập số điện thoại']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Ảnh đại diện</label>
                        <div class="col-sm-10">
                            <span> {!! HTML::image($teacher->image, 'Category image', ['style'=>'width: 100%; max-width: 150px; height: 150px;']) !!} </span>
                            {!! Form::file('image', '', ['class'=>'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Trình độ</label>
                        <div class="col-sm-10">
                            {!! Form::text('experiences', $teacher->image, ['class'=>'form-control', 'placeholder' => 'Nhập trình độ']) !!}
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <a href="{!! URL::previous() !!}" class="btn  btn-default"><<</a>
                    {!! Form::submit('Cập nhật', ['class'=>'btn btn-primary pull-right']) !!}
                </div><!-- /.box-footer -->
            {!! Form::close() !!}
        </div><!-- /.box -->
    </div>
@stop
