@extends('main')

@section('content')
<div class="container">
    <div class="row">
        <form action="" method="GET" role="form" class="col-md-6">
            <legend>Tìm kiếm</legend>
            <div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <select name="selectLevel" id="inputSelectLevel" class="form-control">
                    @foreach ($levels as $item)
                        <option value="{{ $item->id }}" @if($item->id == $selectLevel) selected @endif>{{ $item->grade->grade_name }} {{ $item->level_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <select name="selectSubject" id="inputSelectSubject" class="form-control">
                    @foreach ($subjects as $item)
                        <option value="{{ $item->id }}" @if($item->id == $selectSubject) selected @endif>{{ $item->subject_name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Tìm Kiếm</button>
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

                            @if(session()->has('failed'))
                                <div class="alert alert-warning alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                    {!! session('failed') !!}
                                </div>
                            @endif

                            @if(session()->has('success'))
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4>Success!</h4>
                                    {!! session('success') !!}
                                </div>
                            @endif
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($points as $key => $point)
                                    <tr class="point_{{ $point->id }}">
                                        <td>{{{$key + 1}}}</td>
                                        <td>{{{ $point->student_level->student->student_code }}}</td>
                                        <td width="150px">{{{ $point->student_level->student->name }}}</td>
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
                                        <td>
                                            @if ($point->mark_avg)
                                                {{{$point->mark_avg}}}
                                            @else
                                            @endif
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            @else
                                Danh sách trống
                            @endif
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
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
