@extends('main')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Danh sách kỳ học</h3>
                        <a href="{!! route('admin.semesters.create') !!}" class="btn btn-primary pull-right">Thêm mới</a>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            @if(count($semesters) > 0)
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên kỳ học</th>
                                    <th>Chỉnh sửa</th>
                                    <th>Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($semesters as $semester)
                                <tr>
                                    <td>{{{ $semester->id }}}</td>
                                    <td>{!! nl2br($semester->semester_code) !!}</td>
                                    <td><a href="{!! route('admin.semesters.edit', $semester->id) !!}" class="btn btn-primary">Sửa</a></td>
                                    {!! Form::open(['route' => ['admin.semesters.destroy', $semester->id], 'method' => 'delete']) !!}
                                    <td>{!! Form::submit('Xóa', ['class'=>'btn btn-danger', 'onclick'=>"return confirm('Are you sure you want to delete this item?')"]) !!}</td>
                                    {!! Form::close() !!}
                                </tr>
                                @endforeach
                            </tbody>
                            @else
                               Danh sách kỳ học trống
                            @endif
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
@stop
