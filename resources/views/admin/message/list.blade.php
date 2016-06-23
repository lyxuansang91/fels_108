@extends('main')

@section('content')
<div class="container">
    <div class="row">
        <form action="" method="GET" role="form" class="col-md-6">
            <legend>Tìm kiếm</legend>
            <div class="form-group col-xs-12 col-sm-4">
                <select name="selectStudentLevel" id="inputSelectStudentLevel" class="form-control">
                    <option value>Chọn sinh viên</option>
                    @foreach ($student_levels as $student_level)
                        <option value="{{ $student_level->id }}" @if($student_level->id == $selectStudentLevel) selected @endif>{{ $student_level->student->student_code }}</option>
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
                        <h3 class="box-title"> Bảng tin nhắn </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            @if(session()->has('failed'))
                                <div class="alert alert-warning alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    {!! session('failed') !!}
                                </div>
                            @endif

                            @if(session()->has('success'))
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    {!! session('success') !!}
                                </div>
                            @endif
                            @if ( count($messages) > 0)
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Số điện thoại</th>
                                        <th>Mã học sinh</th>
                                        <th>Tên học sinh</th>
                                        <th>Nội dung tin nhắn</th>
                                        <th>Ngày gửi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($messages as $key => $message)
                                    <tr>
                                        <td>{{{$key + 1}}}</td>
                                        <td>{{{ $message->student_level->student->phone }}}</td>
                                        <td>{{{ $message->student_level->student->student_code }}}</td>
                                        <td>{{{ $message->student_level->student->name }}}</td>
                                        <td>{{ $message->text_message }}</td>
                                        <td>{{ Date('d/m/Y', strtotime($message->created_at)) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                {!! $messages-> render() !!}
                            @else
                                Danh sách trống
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
