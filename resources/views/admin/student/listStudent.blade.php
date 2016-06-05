@extends('main')

@section('content')
<form action="" method="GET" role="form">
    <legend>Search Student</legend>
    <div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3">
        <select name="selectLevel" id="inputSelectLevel" class="form-control">
            @foreach ($levels as $level)
                <option value="{{ $level->id }}" @if($level->id == $selectLevel) selected @endif>{{ $level->grade->grade_name }}-{{ $level->level_name }}</option>
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
                        <h3 class="box-title">List Student</h3>
                        <a href="{!! route('admin.students.create') !!}" class="btn btn-primary pull-right">Create Student</a>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            @if($students->count() > 0)
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Birthday</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Student code</th>
                                    <th>Level Name</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                <tr>
                                    <td>{{{ $student->id }}}</td>
                                    <td>{{{ $student->name }}}</td>
                                    <td>{{{ $student->gender == 0 ? 'Nam': 'Nữ' }}}</td>
                                    <td>{{{ Date('Y-m-d', strtotime($student->birthday)) }}}</td>
                                    <td>{{{ $student->address }}}</td>
                                    <td>{{{ $student->phone }}}</td>
                                    <td> @if ($student->student_code) {{{ $student->student_code }}} @endif </td>
                                    <td>{{{ $student->level->grade->grade_name.'-'.$student->level->level_name }}}</td>
                                    <td><a href="{!! route('admin.students.edit', $student->id) !!}" class="btn btn-primary">Edit</a></td>
                                    {!! Form::open(['route' => ['admin.students.destroy', $student->id], 'method' => 'delete']) !!}
                                    <td>{!! Form::submit('Delete', ['class'=>'btn btn-danger', 'onclick'=>"return confirm('Are you sure you want to delete this item?')"]) !!}</td>
                                    {!! Form::close() !!}
                                </tr>
                                @endforeach
                            </tbody>
                            @else
                                List Student is empty
                            @endif
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
@stop
