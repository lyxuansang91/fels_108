@extends('main')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">List User Point</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            @if ( count($points) > 0)
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Semester Name</th>
                                        <th>Subject Name</th>
                                        <th>Group Name</th>
                                        <th>Level Name</th>
                                        <th>User Name</th>
                                        <th>Mark M 1</th>
                                        <th>Mark M 2</th>
                                        <th>Mark M 3</th>
                                        <th>Mark M 4</th>
                                        <th>Mark 15 1</th>
                                        <th>Mark 15 2</th>
                                        <th>Mark 15 3</th>
                                        <th>Mark 45 1</th>
                                        <th>Mark 45 2</th>
                                        <th>Mark Last</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($points as $point)
                                    <tr>
                                        <td>{{{ $point->id }}}</td>
                                        <td>{!! nl2br($point->semester_subject_group->semester->name) !!}</td>
                                        <td>{{{ $point->semester_subject_group->subject->subject_name }}}</td>
                                        <td>{{{ $point->semester_subject_group->group->group_name }}}</td>
                                        <td>{{{ $point->semester_subject_group->level->level_name }}}</td>
                                        <td>{{{ $point->user->name }}}</td>
                                        <td>{{{ $point->mark_m1 }}}</td>
                                        <td>{{{ $point->mark_m2 }}}</td>
                                        <td>{{{ $point->mark_m3 }}}</td>
                                        <td>{{{ $point->mark_m4 }}}</td>
                                        <td>{{{ $point->mark_15_1 }}}</td>
                                        <td>{{{ $point->mark_15_2 }}}</td>
                                        <td>{{{ $point->mark_15_3 }}}</td>
                                        <td>{{{ $point->mark_45_1 }}}</td>
                                        <td>{{{ $point->mark_45_2 }}}</td>
                                        <td>{{{ $point->mark_last }}}</td>
                                        <td><a href="{!! route('admin.points.edit', $point->id) !!}" class="btn btn-primary">Edit</a></td>
                                        {!! Form::open(['route' => ['admin.points.destroy', $point->id], 'method' => 'delete']) !!}
                                        <td>{!! Form::submit('Delete', ['class'=>'btn btn-danger', 'onclick'=>"return confirm('Are you sure you want to delete this item?')"]) !!}</td>
                                        {!! Form::close() !!}
                                    </tr>
                                    @endforeach
                                </tbody>
                            @else
                                List point is empty
                            @endif
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
@stop
