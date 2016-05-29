@extends('main')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">List Semester Subject Group</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            @if ( count($semester_subject_groups) > 0)
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Semester Name</th>
                                        <th>Subject Name</th>
                                        <th>Group Name</th>
                                        <th>Level Name</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($semester_subject_groups as $semester_subject_group)
                                    <tr>
                                        <td>{{{ $semester_subject_group->id }}}</td>
                                        <td>{!! nl2br($semester_subject_group->semester->name) !!}</td>
                                        <td>{{{ $semester_subject_group->subject->subject_name }}}</td>
                                        <td>{{{ $semester_subject_group->group->group_name }}}</td>
                                        <td>{{{ $semester_subject_group->level->level_name }}}</td>
                                        <td><a href="{!! route('admin.semester_subject_groups.edit', $semester_subject_group->id) !!}" class="btn btn-primary">Edit</a></td>
                                        {!! Form::open(['route' => ['admin.semester_subject_groups.destroy', $semester_subject_group->id], 'method' => 'delete']) !!}
                                        <td>{!! Form::submit('Delete', ['class'=>'btn btn-danger', 'onclick'=>"return confirm('Are you sure you want to delete this item?')"]) !!}</td>
                                        {!! Form::close() !!}
                                    </tr>
                                    @endforeach
                                </tbody>
                            @else
                                List Semester Subject Group is empty
                            @endif
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
@stop
