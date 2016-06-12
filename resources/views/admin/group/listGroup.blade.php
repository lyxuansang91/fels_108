@extends('main')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Danh sách ban học</h3>
                        <a href="{!! route('admin.groups.create') !!}" class="btn btn-primary pull-right">Thêm mới</a>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            @if(count($groups) > 0)
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã ban</th>
                                    <th>Tên ban</th>
                                    <th>Chỉnh sửa</th>
                                    <th>Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($groups as $group)
                                <tr>
                                    <td>{{{ $group->id }}}</td>
                                    <td>{!! nl2br($group->group_code) !!}</td>
                                    <td>{!! nl2br($group->group_name) !!}</td>
                                    <td><a href="{!! route('admin.groups.edit', $group->id) !!}" class="btn btn-primary">Sửa</a></td>
                                    {!! Form::open(['route' => ['admin.groups.destroy', $group->id], 'method' => 'delete']) !!}
                                    <td>{!! Form::submit('Xóa', ['class'=>'btn btn-danger', 'onclick'=>"return confirm('Are you sure you want to delete this item?')"]) !!}</td>
                                    {!! Form::close() !!}
                                </tr>
                                @endforeach
                            </tbody>
                            @else
                                Danh sách ban học trống.
                            @endif
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
@stop
