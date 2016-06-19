@extends('main')

@section('content')
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

                    <div class="box-body table-responsive">
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
                            @if ($semester)
                            <thead>
                                <tr>
                                    <th>Tên khối</th>
                                    <th>Lớp</th>
                                    @foreach($subjects as $subject)
                                        <th>{{ $subject->subject_name }}</th>
                                    @endforeach
                                    <th>Phân lịch</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($grades as $grade)
                                    @foreach($grade->levels as $index => $level)
                                        <tr>
                                            <form action="{{ route('admin.teacher_subjects.calculate') }}" method="POST">
                                                {{ csrf_field() }}
                                                @if($index == 0)
                                                    <td rowspan="{{count($grade->levels)}}">{{ $grade->grade_name }}</td>
                                                @endif
                                                <td>
                                                    <input type="hidden" name="semester_id" value="{{ $semester->id }}" />
                                                    <input type="hidden" name="level_id" value="{{ $level->id }}" />
                                                    {{ $level->level_name }}
                                                </td>
                                                @foreach($subjects as $index_subject => $subject)
                                                    <td>
                                                        <input type="hidden" name="teacher_subjects[{{ $index_subject }}][subject_id]" value="{{ $subject->id }}" />
                                                        <select name="teacher_subjects[{{ $index_subject }}][teacher_id]" id="inputSelectLevel">
                                                            <option value>Vui lòng chọn</option>
                                                            @foreach ($subject->teachers as $teacher)
                                                                <?php $semester_subject_level = $semester->semester_subject_levels()
                                                                    ->where('subject_id', $subject->id)
                                                                    ->where('level_id', $level->id)
                                                                    ->where('teacher_id', $teacher->id)->first(); ?>
                                                                <option value="{{ $teacher->id }}"
                                                                    @if ($semester_subject_level && $semester_subject_level->teacher_id == $teacher->id)
                                                                     selected
                                                                    @endif
                                                                >{{$teacher->teacher_code}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                @endforeach
                                            <td><button type="submit" class="btn btn-primary">Phân lịch</button></td>
                                            </form>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                            @else
                                Chưa có dữ liệu
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
