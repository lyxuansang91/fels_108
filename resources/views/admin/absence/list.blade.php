@extends('main')

@section('content')

<form action="" method="GET" role="form" class="col-md-6">
    <legend>Tìm kiếm</legend>
    <div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3">
        <select name="selectLevel" id="inputSelectLevel" class="form-control">
            @foreach ($levels as $item)
                <option value="{{ $item->id }}" @if($item->id == $selectLevel) selected @endif>{{ $item->grade->grade_name }} {{ $item->level_name }}</option>
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
                        <h3 class="box-title">Danh sách nghỉ học</h3>
                        <a href="{!! route('admin.absences.create', ['selectLevel'=> $selectLevel]) !!}" class="btn btn-primary pull-right">Thêm mới</a>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        @if ($semester)
                        <table id="example1" class="table table-bordered table-striped">
                            @if (count($absences) > 0)
                                <thead>
                                    <tr>
                                        <th>Mã học sinh</th>
                                        <th>Tên học sinh</th>
                                        <th>Lớp</th>
                                        <th>Ngày nghỉ</th>
                                        <th>Môn học</th>
                                        <th>Lý do</th>
                                        <th>Sửa</th>
                                        <th>Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($absences as $absence)
                                    <tr>
                                        <td>{{{ $absence->student->student_code }}}</td>
                                        <td>{!! nl2br($absence->student->name) !!}</td>
                                        <td>{{{ $absence->student->level->grade->grade_name.'-'.$absence->student->level->level_name }}}</td>
                                        <td>{{{ date('Y-m-d', strtotime($absence->absence_day)) }}}</td>
                                        <td>{{{ $absence->subject->subject_name }}}</td>
                                        <td>{{{ $absence->reason }}}</td>
                                        <td><a href="{!! route('admin.absences.edit', $absence->id) !!}" class="btn btn-primary">Sửa</a></td>
                                        {!! Form::open(['route' => ['admin.absences.destroy', $absence->id], 'method' => 'delete']) !!}
                                        <td>{!! Form::submit('Xóa', ['class'=>'btn btn-danger', 'onclick'=>"return confirm('Bạn có chắc chắn muốn xóa?')"]) !!}</td>
                                        {!! Form::close() !!}
                                    </tr>
                                    @endforeach
                                </tbody>
                            @else
                                Chưa có dữ liệu
                            @endif
                        </table>
                        @else
                            Chưa có kỳ học nào
                        @endif
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
@stop
