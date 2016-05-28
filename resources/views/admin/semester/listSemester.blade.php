@extends('main')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">List Semester</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            @if(count($semesters) > 0)
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Semester Name</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($semesters as $semester)
                                <tr>
                                    <td>{{{ $semester->id }}}</td>
                                    <td>{!! nl2br($semester->name) !!}</td>
                                    <td><a href="{!! route('admin.semesters.edit', $semester->id) !!}" class="btn btn-primary">Edit</a></td>
                                    {!! Form::open(['route' => ['admin.semesters.destroy', $semester->id], 'method' => 'delete']) !!}
                                    <td>{!! Form::submit('Delete', ['class'=>'btn btn-danger', 'onclick'=>"return confirm('Are you sure you want to delete this item?')"]) !!}</td>
                                    {!! Form::close() !!}
                                </tr>
                                @endforeach
                            </tbody>
                            @else
                                List Grades is empty
                            @endif
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
@stop
