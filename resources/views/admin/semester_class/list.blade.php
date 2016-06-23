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

            <button type="submit" class="btn btn-primary">Tìm Kiếm</button>
        </form>
    </div>



</div>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">
                            @if ($semester)
                                {{ 'Kỳ '. $semester->semester_number.' năm học ' . $semester->year }}
                            @endif
                        </h3>
                    </div><!-- /.box-header -->

                    <a href=" @if ($selectLevel)
                        {{ route('admin.semester_classes.calculate', ['selectLevel'=> $selectLevel]) }}
                    @else
                    {{ route('admin.semester_classes.calculate') }}
                    @endif "
                    class="btn btn-primary"> Tính điểm TK</a>

                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            @if ( count($students) > 0 && $semester)
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Mã học sinh</th>
                                        <th width="150px">Tên học sinh</th>
                                        @foreach ($subjects as $subject)
                                            <th>{{ $subject->subject_name }}</th>
                                        @endforeach
                                        <th>Điểm tổng kết</th>
                                        <th>Học lực</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $key => $student)
                                    <tr>
                                        <td>{{{$key + 1}}}</td>
                                        <td>{{{ $student->student_code }}}</td>
                                        <td>{{{ $student->name }}}</td>
                                        @foreach($subjects as $subject)
                                            <td>
                                                <?php $point = $student->getPointBySubjectAndSemester($subject->id, $semester->id); ?>
                                                @if ($point)
                                                    {{ $point->mark_avg }}
                                                @endif
                                            </td>
                                        @endforeach
                                        <td>
                                            <?php if($semester) $semester_point = $student->active_student_level()->semester_points()->where('semester_id', $semester->id)->first(); ?>
                                            @if ($semester_point)
                                                {{ $semester_point->mark }}
                                            @endif
                                        </td>
                                        <td>
                                            <?php if($semester) $semester_point = $student->active_student_level()->semester_points()->where('semester_id', $semester->id)->first(); ?>
                                            @if ($semester_point)
                                                {{ $semester_point->evaluate }}
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            @else
                                Danh sách rỗng
                            @endif
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <div class="col-xs-12">
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
