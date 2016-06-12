@extends('main')

@section('content')

    <div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Sửa thông tin ban học</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route'=>['admin.groups.update', $group->id], 'method'=>'put', 'class'=>'form-horizontal', 'files' => true]) !!}
                <div class="box-body">
                    @if(count($errors) > 0)
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Vui lòng điền đầy đủ thông tin trước khi thay đổi!</h4>
                        @foreach($errors->all() as $error)
                            <li>{!! $error !!}</li>
                        @endforeach
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Tên ban học</label>
                        <div class="col-sm-10">
                            {!! Form::text('group_name', $group->group_name, ['class'=>'form-control', 'placeholder'=>'Tên ban học']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Mã ban học</label>
                        <div class="col-sm-10">
                            {!! Form::text('group_code', $group->group_code, ['class'=>'form-control', 'placeholder'=>'Mã ban học']) !!}
                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <a href="{!! URL::previous() !!}" class="btn  btn-default"><<</a>
                    {!! Form::submit('Cập nhật', ['class'=>'btn btn-primary pull-right']) !!}
                </div><!-- /.box-footer -->
            {!! Form::close() !!}
        </div><!-- /.box -->
    </div>
@stop
