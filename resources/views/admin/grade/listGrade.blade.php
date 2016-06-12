@extends('main')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Danh sách khối học</h3>
                        <a href="{!! route('admin.grades.create') !!}" class="btn btn-primary pull-right">Tạo mới</a>

                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            @if(count($grades) > 0)
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên khối</th>
                                    <th>Chỉnh sửa</th>
                                    <th>Xóa </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($grades as $grade)
                                <tr>
                                    <td>{{{ $grade->id }}}</td>
                                    <td>{!! nl2br($grade->grade_name) !!}</td>
                                    <td><a href="{!! route('admin.grades.edit', $grade->id) !!}" class="btn btn-primary">Sửa</a></td>
                                    {!! Form::open(['route' => ['admin.grades.destroy', $grade->id], 'method' => 'delete']) !!}
                                    <td>{!! Form::submit('Xóa', ['class'=>'btn btn-danger', 'onclick'=>"return confirm('Bạn có chắc chắn muốn xóa lớp hiện tại?')"]) !!}</td>
                                    {!! Form::close() !!}
                                </tr>
                                @endforeach
                            </tbody>
                            @else
                                Danh sách lớp học trống
                            @endif
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
@stop
