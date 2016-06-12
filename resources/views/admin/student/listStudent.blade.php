@extends('main')

@section('content')
<form action="" method="GET" role="form">
    <legend>Tìm kiếm</legend>
    <div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3">
        <select name="selectLevel" id="inputSelectLevel" class="form-control">
            @foreach ($levels as $level)
                <option value="{{ $level->id }}" @if($level->id == $selectLevel) selected @endif>{{ $level->grade->grade_name }}-{{ $level->level_name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Tìm Kiếm</button>
</form>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Danh sách học sinh</h3>
                        <a href="{!! route('admin.students.create') !!}" class="btn btn-primary pull-right">Thêm mới</a>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            @if($students->count() > 0)
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Họ và tên</th>
                                    <th>Giới tính</th>
                                    <th>Ngày sinh</th>
                                    <th>Địa chỉ</th>
                                    <th>Số điện thoại</th>
                                    <th>Mã ban học</th>
                                    <th>Tên lớp học</th>
                                    <th>Chỉnh sửa</th>
                                    <th>Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                <tr>
                                    <td>{{{ $student->id }}}</td>
                                    <td>{{{ $student->name }}}</td>
                                    <td>{{{ $student->gender == 0 ? 'Nam': 'Nữ' }}}</td>
                                    <td>{{{ Date('Y-m-d', strtotime($student->birthday)) }}}</td>
                                    <td>{{{ $student->address }}}</td>
                                    <td>{{{ $student->phone }}}</td>
                                    <td> @if ($student->student_code) {{{ $student->student_code }}} @endif </td>
                                    <td>{{{ $student->level->grade->grade_name.'-'.$student->level->level_name }}}</td>
                                    <td><a href="{!! route('admin.students.edit', $student->id) !!}" class="btn btn-primary">Sửa</a></td>
                                    {!! Form::open(['route' => ['admin.students.destroy', $student->id], 'method' => 'delete']) !!}
                                    <td>{!! Form::submit('Xóa', ['class'=>'btn btn-danger', 'onclick'=>"return confirm('Bạn có chắc chắn muốn xóa học sinh này?')"]) !!}</td>
                                    {!! Form::close() !!}
                                </tr>
                                @endforeach
                            </tbody>
                            @else
                                Danh sách học sinh trống
                            @endif
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <div class="col-xs-12">
                <a href="#" class="btn btn-primary">Nhập excel</a>
                <a href="#" class="btn btn-primary">Xuất excel</a>
            </div>
        </div>
    </section><!-- /.content -->
@stop
