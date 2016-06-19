@extends('main')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Danh sách lớp học</h3>
                        <a href="{!! route('admin.levels.create') !!}" class="btn btn-primary pull-right">Thêm mới</a>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            @if ( count($levels) > 0)
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Lớp học</th>
                                        <th>Khối học</th>
                                        <th>Ban học</th>
                                        <th>Giáo viên chủ nhiệm</th>
                                        <th>Thay đổi</th>
                                        <th>Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($levels as $level)
                                    <tr>
                                        <td>{{{ $level->id }}}</td>
                                        <td>{!! nl2br($level->level_name) !!}</td>
                                        <td>{{{ $level->grade->grade_name }}}</td>
                                        <td>{{{ $level->group->group_name }}}</td>
                                        <td>
                                            @if ($level->teacher)
                                                {{{ $level->teacher->teacher_name }}}
                                            @endif
                                        </td>
                                        <td><a href="{!! route('admin.levels.edit', $level->id) !!}" class="btn btn-primary">Sửa</a></td>
                                        {!! Form::open(['route' => ['admin.levels.destroy', $level->id], 'method' => 'delete']) !!}
                                        <td>{!! Form::submit('Xóa', ['class'=>'btn btn-danger', 'onclick'=>"return confirm('Bạn có chắc chắn muốn xóa giáo viên này?')"]) !!}</td>
                                        {!! Form::close() !!}
                                    </tr>
                                    @endforeach
                                </tbody>
                            @else
                                Chưa có dữ liệu
                            @endif
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
@stop
