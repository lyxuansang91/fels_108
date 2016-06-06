@extends('main')

@section('content')
<div class="container">
    <div class="row">
<form action="" method="GET" role="form" class="col-md-6">
    <legend>Tìm kiếm</legend>
    <div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3">
        <select name="selectLevel" id="inputSelectLevel" class="form-control">
            @foreach ($levels as $item)
                <option value="{{ $item->id }}" @if($item->id == $selectLevel) selected @endif>{{ $item->grade->grade_name }} {{ $item->level_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3">
        <select name="selectSubject" id="inputSelectLevel" class="form-control">
            @foreach ($subjects as $item)
                <option value="{{ $item->id }}" @if($item->id == $selectSubject) selected @endif>{{ $item->subject_name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Tìm Kiếm</button>
</form>

<form action="{{route('points.calculatePoint')}}" method="POST" role="form" class="col-md-6">
    <legend>Tính điểm</legend>
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
    <input type="hidden" name="selectLevel" value="{{ $selectLevel }}">
    <input type="hidden" name="selectSubject" value="{{ $selectSubject }}">
    <input type="submit" class="btn btn-primary" name="calculate" value="Tính điểm" />
</form>
</div>
</div>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Bảng điểm</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            @if ( count($points) > 0)
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Mã học sinh</th>
                                        <th width="150px">Tên học sinh</th>
                                        <th>Điểm miệng 1</th>
                                        <th>Điểm miệng 2</th>
                                        <th>Điểm miệng 3</th>
                                        <th>Điểm miệng 4</th>
                                        <th>Điểm 15 phút 1</th>
                                        <th>Điểm 15 phút 2</th>
                                        <th>Điểm 15 phút 3</th>
                                        <th>Điểm 45 phút 1</th>
                                        <th>Điểm 45 phút 2</th>
                                        <th>Điểm thi</th>
                                        <th>Điểm tổng kết</th>
                                        <th>Edit</th>
                                        <th>Save</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($points as $key => $point)
                                    <tr class="point_{{ $point->id }}">
                                        <!-- <td>{{{ $point->id }}}</td> -->
                                        <!-- <td>{!! nl2br($point->semester_subject_level->semester->semester_code) !!}</td> -->
                                        <!-- <td>{{{ $point->semester_subject_level->subject->subject_name }}}</td> -->
                                        <!-- <td>{{{ $point->semester_subject_level->level->grade->grade_name.'-'.$point->semester_subject_level->level->level_name }}}</td> -->
                                        <td>{{{$key + 1}}}</td>
                                        <td>{{{ $point->student->student_code }}}</td>
                                        <td width="150px">{{{ $point->student->name }}}</td>
                                        <td><input type="text" name="mark_m1" id="mark_m1" value="{{{ $point->mark_m1 }}}" size="3" readonly="true"></td>
                                        <td><input type="text" name="mark_m2" id="mark_m2" value="{{{ $point->mark_m2 }}}" size="3" readonly="true"></td>
                                        <td><input type="text" name="mark_m3" id="mark_m3" value="{{{ $point->mark_m3 }}}" size="3" readonly="true"></td>
                                        <td><input type="text" name="mark_m4" id="mark_m4" value="{{{ $point->mark_m4 }}}" size="3" readonly="true"></td>
                                        <td><input type="text" name="mark_15_1" id="mark_15_1" value="{{{ $point->mark_15_1 }}}" size="3" readonly="true"></td>
                                        <td><input type="text" name="mark_15_2" id="mark_15_2" value="{{{ $point->mark_15_2 }}}" size="3" readonly="true"></td>
                                        <td><input type="text" name="mark_15_3" id="mark_15_3" value="{{{ $point->mark_15_3 }}}" size="3" readonly="true"></td>
                                        <td><input type="text" name="mark_45_1" id="mark_45_1" value="{{{ $point->mark_45_1 }}}" size="3" readonly="true"></td>
                                        <td><input type="text" name="mark_45_2" id="mark_45_2" value="{{{ $point->mark_45_2 }}}" size="3" readonly="true"></td>
                                        <td><input type="text" name="mark_last" id="mark_last" value="{{{ $point->mark_last }}}" size="3" readonly="true"></td>
                                        <td>
                                            @if ($point->mark_avg)
                                                {{{$point->mark_avg}}}
                                            @else
                                            @endif
                                        </td>
                                        <td><a href="javascript:void(0)" class="btn btn-primary editPoint" id="{{{ $point->id }}}">Edit</a></td>
                                        <!-- <td><a href="{!! route('admin.points.edit', $point->id) !!}" class="btn btn-primary">Edit</a></td> -->
                                        <td><a href="javascript:void(0)" class="btn btn-success savePoint" id="{{{ $point->id }}}" disabled>Save</a></td>
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
        <div class="row">
            <div class="col-xs-12">
                <a href="#" class="btn btn-primary">Nhập excel</a>
                <a href="#" class="btn btn-primary">Xuất excel</a>
            </div>
        </div>
    </section><!-- /.content -->
    <script src="{{ Asset('plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>

    <script type="text/javascript">

    jQuery(document).ready(function() {
        jQuery(".editPoint").click(function(){
            var id = jQuery(this).attr('id');
            var point_id = ".point_"+id+" input";
            jQuery(point_id).removeAttr('readonly');
            jQuery(".point_"+id+" .savePoint").removeAttr('disabled');
            jQuery(this).attr('disabled', 'true');

        });

        jQuery(".savePoint").click(function() {
            token = "{{ csrf_token() }}";
            var id = jQuery(this).attr('id');
            var point_id = ".point_"+id;
            jQuery(point_id + " input").attr('readonly', 'true');
            var mark_m1 = jQuery(point_id + " #mark_m1").val();
            var mark_m2 = jQuery(point_id + " #mark_m2").val();
            var mark_m3 = jQuery(point_id + " #mark_m3").val();
            var mark_m4 = jQuery(point_id + " #mark_m4").val();
            var mark_15_1 = jQuery(point_id + " #mark_15_1").val();
            var mark_15_2 = jQuery(point_id + " #mark_15_2").val();
            var mark_15_3 = jQuery(point_id + " #mark_15_3").val();
            var mark_15_4 = jQuery(point_id + " #mark_15_4").val();
            var mark_45_1 = jQuery(point_id + " #mark_45_1").val();
            var mark_45_2 = jQuery(point_id + " #mark_45_2").val();
            var mark_last = jQuery(point_id + " #mark_last").val();
            $.ajax({
                url: "{{ route('points.updatePoint') }}",
                type: 'POST',
                dataType: 'JSON',
                data: {mark_m1: mark_m1,mark_m2: mark_m2,mark_m3: mark_m3,mark_m4: mark_m4,mark_15_1: mark_15_1,mark_15_2: mark_15_2,mark_15_3: mark_15_3,mark_15_4: mark_15_4,mark_45_1: mark_45_1,mark_45_2: mark_45_2,mark_last: mark_last, _token: token, id: id},
                success: function(result){
                    jQuery(".point_"+id+" .editPoint").removeAttr('disabled');
                    jQuery(".point_"+id+" .savePoint").attr('disabled', 'true');
                }
            });


        });
    });
    </script>
@stop
