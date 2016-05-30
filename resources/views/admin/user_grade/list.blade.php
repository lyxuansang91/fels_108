@extends('main')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">List User grade</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            @if ( count($user_grades) > 0)
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>grade Name</th>
                                        <th>User Name</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user_grades as $user_grade)
                                    <tr>
                                        <td>{{{ $user_grade->id }}}</td>
                                        <td>{{{ $user_grade->grade->grade_name }}}</td>
                                        <td>{{{ $user_grade->user->name }}}</td>
                                        <td><a href="{!! route('admin.user_grades.edit', $user_grade->id) !!}" class="btn btn-primary">Edit</a></td>
                                        {!! Form::open(['route' => ['admin.user_grades.destroy', $user_grade->id], 'method' => 'delete']) !!}
                                        <td>{!! Form::submit('Delete', ['class'=>'btn btn-danger', 'onclick'=>"return confirm('Are you sure you want to delete this item?')"]) !!}</td>
                                        {!! Form::close() !!}
                                    </tr>
                                    @endforeach
                                </tbody>
                            @else
                                List User grade is empty
                            @endif
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
@stop
