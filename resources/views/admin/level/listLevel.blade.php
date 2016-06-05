@extends('main')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">List Level</h3>
                        <a href="{!! route('admin.levels.create') !!}" class="btn btn-primary pull-right">Create Level</a>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            @if ( count($levels) > 0)
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Level Name</th>
                                        <th>Grade Name</th>
                                        <th>Group Name</th>
                                        <th>Main Teacher Name</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
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
                                                {{{ $level->teacher->teacher_name.'-'.$level->teacher->id }}}
                                            @endif
                                        </td>
                                        <td><a href="{!! route('admin.levels.edit', $level->id) !!}" class="btn btn-primary">Edit</a></td>
                                        {!! Form::open(['route' => ['admin.levels.destroy', $level->id], 'method' => 'delete']) !!}
                                        <td>{!! Form::submit('Delete', ['class'=>'btn btn-danger', 'onclick'=>"return confirm('Are you sure you want to delete this item?')"]) !!}</td>
                                        {!! Form::close() !!}
                                    </tr>
                                    @endforeach
                                </tbody>
                            @else
                                List Level is empty
                            @endif
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
@stop
