@extends('main')s

@section('content')
<form action="" method="GET" role="form">
    <legend>Tìm kiếm</legend>
    <div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3">
        <select name="subject" id="inputSelectLevel" class="form-control">
            @foreach ($subjects as $subject)
                <option value="{{ $subject->id }}" @if($subject->id == $selectSubject) selected @endif> {{$subject->subject_name }}</option>
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
                        <h3 class="box-title">Danh sách giáo viên</h3>
                        <a href="{!! route('admin.teachers.create') !!}" class="btn btn-primary pull-right">Thêm mới</a>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            @if(session()->has('failed'))
                                <div class="alert alert-warning alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                    {!! session('failed') !!}
                                </div>
                            @endif

                            @if(session()->has('success'))
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4>Success!</h4>
                                    {!! session('success') !!}
                                </div>
                            @endif
                            @if($teachers->count() > 0)
                            <thead>
                                <tr>
                                    <th>Mã giáo viên</th>
                                    <th>Họ và tên</th>
                                    <th>Giới tính</th>
                                    <th>Ngày sinh</th>
                                    <th>Địa chỉ</th>
                                    <th>Điện thoại</th>
                                    <th>Môn dạy</th>
                                    <th>Email</th>
                                    <th>Chỉnh sửa</th>
                                    <th>Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teachers as $teacher)
                                <tr>
                                    <td><a href="{{ route('admin.teachers.show', $teacher->id) }}">{{ $teacher->teacher_code }}</a></td>
                                    <td>{{{ $teacher->teacher_name }}}</td>
                                    <td>{{{ $teacher->gender == 0 ? 'Nam': 'Nữ' }}}</td>
                                    <td>{{{ Date('Y-m-d', strtotime($teacher->birthday)) }}}</td>
                                    <td>{{{ $teacher->address }}}</td>
                                    <td>{{{ $teacher->phone }}}</td>
                                    <td> @if ($teacher->subject) {{{$teacher->subject->subject_name}}} @endif</td>
                                    <td> @if ($teacher->user) {{{$teacher->user->email}}} @endif</td>
                                    <td><a href="{!! route('admin.teachers.edit', $teacher->id) !!}" class="btn btn-primary">Sửa</a></td>
                                    {!! Form::open(['route' => ['admin.teachers.destroy', $teacher->id], 'method' => 'delete']) !!}
                                    <td>{!! Form::submit('Xóa', ['class'=>'btn btn-danger', 'onclick'=>"return confirm('Bạn có chắc chắn muốn xóa giáo viên hiện tại?')"]) !!}</td>
                                    {!! Form::close() !!}
                                </tr>
                                @endforeach
                                {!! $teachers->render() !!}
                            </tbody>
                            @else
                                Danh sách giáo viên trống
                            @endif
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <div class="col-xs-6">
                <form class="col-md-6" action="{{ route('teachers.importExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
        			<input type="file" name="excel_file" />
        			<button class="btn btn-primary">Nhập excel</button>
                    <a href="{{ route('teachers.exportExcel', ['selectSubject' => $selectSubject]) }}" class="btn btn-primary">Xuất excel</a>
		        </form>

            </div>
        </div>
    </section><!-- /.content -->
@stop
