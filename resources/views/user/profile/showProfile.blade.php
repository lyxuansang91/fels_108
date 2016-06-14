@extends('user.main')

@section('content')
    <!-- Main content -->
    {{-- <section class="content"> --}}
    <div class="content-wrapper" style="min-height: 449px;">
        <div class="container">
            <div class="col-md-12">
                <div class="box">
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
                        <li class="active">Trang cá nhân</li>
                    </ol>
                    <div class="row">
                        <div class="col-md-3" style="text-align: center;">
                            <img src="{{ Asset('images/avatar/default.png')}}" height="100px" width="100px" Alt="User Name" />
                            <div class="row" style="text-align:center;">
                                <h3>Họ tên: {{{$student->name}}}</h3>
                                <h4>Lớp: {{{$student->level->level_name.'-'. $student->level->grade->grade_name}}}</h4>
                                <p>Ngày sinh: {{{$student->birthday}}}</p>
                                <p>Địa chỉ: {{{$student->address}}}</p>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <table id="example1" class="table table-bordered table-striped">
                                @if (count($points) > 0)
                                    <thead>
                                        <tr>
                                            <th>Học kỳ</th>
                                            <th>Môn</th>
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
                                            <th>Điểm TK</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($points as $point)
                                        <tr>
                                            <td>{!! nl2br($point->semester_subject_level->semester->semester_code) !!}</td>
                                            <td>{{{ $point->semester_subject_level->subject->subject_name }}}</td>
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
                                            <td>{{{ $point->mark_avg }}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                @else
                                    List point is empty
                                @endif
                            </table>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>
@stop
