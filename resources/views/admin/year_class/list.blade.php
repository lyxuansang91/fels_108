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
                                {{ 'Năm học ' . $semester->year }}
                            @endif
                        </h3>
                    </div><!-- /.box-header -->

                    <!-- <a href=" @if ($selectLevel)
                        {{ route('admin.semester_classes.calculate', ['selectLevel'=> $selectLevel]) }}
                    @else
                    {{ route('admin.semester_classes.calculate') }}
                    @endif "
                    class="btn btn-primary"> Tính điểm TK</a> -->

                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            @if ( count($students) > 0 && $semester)
                                <thead>
                                    <tr>
                                        <th rowspan="2">ID</th>
                                        <th rowspan="2">Mã học sinh</th>
                                        <th rowspan="2" width="150">Tên học sinh</th>
                                        @foreach ($subjects as $subject)
                                            <th colspan="3">
                                                {{ $subject->subject_name }}
                                            </th>
                                        @endforeach
                                        <th colspan="3">Điểm tổng kết</th>
                                        <th colspan="3">Học lực</th>
                                    </tr>
                                    <tr>
                                        @foreach ($subjects as $subject)
                                            <th>Kỳ 1</th>
                                            <th>Kỳ 2</th>
                                            <th>Cả năm</th>
                                        @endforeach
                                        <th>Kỳ 1</th>
                                        <th>Kỳ 2</th>
                                        <th>Cả năm</th>
                                        <th>Kỳ 1</th>
                                        <th>Kỳ 2</th>
                                        <th>Cả năm</th>
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
                                                <?php $point_1 = $student->getPointBySubjectAndYear($subject->id, $semester->year, 1); ?>
                                                    @if ($point_1 && $point_1->mark_avg != NULL)
                                                        {{ $point_1->mark_avg }}
                                                    @endif
                                            </td>
                                            <td>
                                                <?php $point_2 = $student->getPointBySubjectAndYear($subject->id, $semester->year, 2); ?>
                                                    @if ($point_2 && $point_2->mark_avg != NULL)
                                                        {{ $point_2->mark_avg }}
                                                    @endif
                                            </td>
                                            <td>
                                                @if ($point_1 && $point_2 && $point_1->mark_avg != NULL && $point_2->mark_avg != NULL)
                                                    {{ number_format(($point_1->mark_avg + ($point_2->mark_avg * 2)) / 3, 1) }}
                                                @endif
                                            </td>
                                        @endforeach
                                        <td>
                                            <?php $semester_point_1 = $student->getSemesterPointBySemester($semester->year, 1); ?>
                                            @if ($semester_point_1 && $semester_point_1->mark != NULL)
                                                {{ $semester_point_1->mark }}
                                            @endif
                                        </td>
                                        <td>
                                            <?php $semester_point_2 = $student->getSemesterPointBySemester($semester->year, 2); ?>
                                            @if ($semester_point_2 && $semester_point_2->mark != NULL)
                                                {{ $semester_point_2->mark }}
                                            @endif

                                        </td>
                                        <td>
                                            @if ($semester_point_1 && $semester_point_1->mark != NULL && $semester_point_2 && $semester_point_2->mark != NULL)
                                                {{ number_format(($semester_point_1->mark + $semester_point_2->mark * 2) / 3, 1) }}
                                            @endif

                                            <!-- tính điểm TK năm học-->
                                        </td>

                                        <td>
                                            <?php $semester_point_1 = $student->getSemesterPointBySemester($semester->year, 1); ?>
                                            @if ($semester_point_1 && $semester_point_1->evaluate != NULL)
                                                {{ $semester_point_1->evaluate }}
                                            @endif
                                        </td>
                                        <td>
                                            <?php $semester_point_2 = $student->getSemesterPointBySemester($semester->year, 2); ?>
                                            @if ($semester_point_2 && $semester_point_2->evaluate != NULL)
                                                {{ $semester_point_2->evaluate }}
                                            @endif

                                        </td>
                                        <td>
                                            @if ($semester_point_1 && $semester_point_1->evaluate != NULL && $semester_point_2 && $semester_point_2->evaluate != NULL)
                                                {{ $semester_point_2->evaluate }}
                                            @endif

                                            <!-- tính điểm TK năm học-->
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
