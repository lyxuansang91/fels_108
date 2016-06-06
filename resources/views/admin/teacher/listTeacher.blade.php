@extends('main')

@section('content')
<form action="" method="GET" role="form">
    <legend>Search Teacher</legend>
    <div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3">
        <select name="subject" id="inputSelectLevel" class="form-control">
            @foreach ($subjects as $subject)
                <option value="{{ $subject->id }}" @if($subject->id == $selectSubject) selected @endif> {{$subject->subject_name }}</option>
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
                        <h3 class="box-title">List Teacher</h3>
                        <a href="{!! route('admin.teachers.create') !!}" class="btn btn-primary pull-right">Create Teacher</a>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            @if($teachers->count() > 0)
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Birthday</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Subject</th>
                                    <th>Email</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teachers as $teacher)
                                <tr>
                                    <td>{{{ $teacher->id }}}</td>
                                    <td>{{{ $teacher->teacher_name }}}</td>
                                    <td>{{{ $teacher->gender == 0 ? 'Nam': 'Nữ' }}}</td>
                                    <td>{{{ Date('Y-m-d', strtotime($teacher->birthday)) }}}</td>
                                    <td>{{{ $teacher->address }}}</td>
                                    <td>{{{ $teacher->phone }}}</td>
                                    <td> @if ($teacher->subject) {{{$teacher->subject->subject_name}}} @endif</td>
                                    <td> @if ($teacher->user) {{{$teacher->user->email}}} @endif</td>
                                    <td><a href="{!! route('admin.teachers.edit', $teacher->id) !!}" class="btn btn-primary">Edit</a></td>
                                    {!! Form::open(['route' => ['admin.teachers.destroy', $teacher->id], 'method' => 'delete']) !!}
                                    <td>{!! Form::submit('Delete', ['class'=>'btn btn-danger', 'onclick'=>"return confirm('Are you sure you want to delete this item?')"]) !!}</td>
                                    {!! Form::close() !!}
                                </tr>
                                @endforeach
                            </tbody>
                            @else
                                List Teacher is empty
                            @endif
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <div class="col-xs-12">
                <a href="#" class="btn btn-primary">Nhập excel</a>
                <a href="#" class="btn btn-primary">Xuất excel</a>
            </div>
        </div>
    </section><!-- /.content -->
@stop
