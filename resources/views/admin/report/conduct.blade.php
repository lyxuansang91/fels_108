@extends('main')

@section('content')

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
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Danh sách hạnh kiểm</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            @if ( count($conducts) > 0)
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã học sinh</th>
                                        <th>Họ và tên</th>
                                        <th>Hạnh kiểm</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($conducts as $conduct)
                                    <tr class="conduct_{{ $conduct->id }}">
                                        <td>{{{ $conduct->id }}}</td>
                                        <td>{{{ $conduct->student_level->student->student_code }}}</td>
                                        <td>{{{ $conduct->student_level->student->name }}}</td>
                                        <td>
                                            @if($conduct->conduct_name == 1)
                                            Tốt
                                            @endif
                                            @if($conduct->conduct_name == 2)
                                            Khá
                                            @endif
                                            @if($conduct->conduct_name == 3)
                                            Trung Bình
                                            @endif
                                            @if($conduct->conduct_name == 4)
                                            Yếu
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            @else
                               Danh sách hạnh kiểm trống
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
        jQuery(".editConduct").click(function(){
            var id = jQuery(this).attr('id');
            var conduct_id = ".conduct_"+id+" select";
            jQuery(conduct_id).removeAttr('readonly');
            jQuery(".conduct_"+id+" .saveConduct").removeAttr('disabled');
            jQuery(this).attr('disabled', 'true');

        });

        jQuery(".saveConduct").click(function() {
            token = "{{ csrf_token() }}";
            var id = jQuery(this).attr('id');
            var conduct_id = ".conduct_"+id;
            jQuery(conduct_id + " select").attr('readonly', 'true');
            var conduct_name = jQuery(conduct_id + " #conduct_name option:selected").val();
            $.ajax({
                url: "{{ route('conducts.updateConduct') }}",
                type: 'POST',
                dataType: 'JSON',
                data: {conduct_name: conduct_name, _token: token, id: id},
                success: function(result){
                    jQuery(".conduct_"+id+" .editConduct").removeAttr('disabled');
                    jQuery(".conduct_"+id+" .saveConduct").attr('disabled', 'true');
                    console.log(result);
                }
            });


        });
    });
    </script>
@stop
