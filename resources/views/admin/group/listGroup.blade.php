@extends('main')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">List Group</h3>
                        <a href="{!! route('admin.groups.create') !!}" class="btn btn-primary pull-right">Create Group</a>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            @if(count($groups) > 0)
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Mã ban</th>
                                    <th>Tên ban</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($groups as $group)
                                <tr>
                                    <td>{{{ $group->id }}}</td>
                                    <td>{!! nl2br($group->group_code) !!}</td>
                                    <td>{!! nl2br($group->group_name) !!}</td>
                                    <td><a href="{!! route('admin.groups.edit', $group->id) !!}" class="btn btn-primary">Edit</a></td>
                                    {!! Form::open(['route' => ['admin.groups.destroy', $group->id], 'method' => 'delete']) !!}
                                    <td>{!! Form::submit('Delete', ['class'=>'btn btn-danger', 'onclick'=>"return confirm('Are you sure you want to delete this item?')"]) !!}</td>
                                    {!! Form::close() !!}
                                </tr>
                                @endforeach
                            </tbody>
                            @else
                                List Group is empty
                            @endif
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
@stop
