@extends('main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      	<h1>
            Trang chủ
            <small></small>
      	</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      	<!-- Small boxes (Stat box) -->
      	<div class="row">
        	<div class="col-lg-3 col-xs-6">
          	<!-- small box -->
          		<div class="small-box bg-aqua">
            		<div class="inner">
              			<h3>{!! $users->count() !!}</h3>
              			<p>người dùng</p>
            		</div>
            		<div class="icon">
              			<i class="ion ion-person"></i>
            		</div>
            		<a href="#" class="small-box-footer">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
          		</div>
        	</div><!-- ./col -->
      </div><!-- /.row -->

      @if (\Auth()->user()->role == \App\Models\User::ROLE_TEACHER)

      <div class="row">
          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
            <h2>Lịch giảng dạy</h2>
                <?php
                    $semester = \App\Models\Semester::all()->last();
                    $teacher = \Auth()->user()->teacher();
                    if($semester)
                        $semester_teacher = \App\Models\SemesterTeacher::where('teacher_id', $teacher->id)
                            ->where('semester_id', $semester->id)->first();
                 ?>
                 @if ($semester_teacher && $semester_teacher->teacher_calendar)
                    <span> {!! HTML::image($semester_teacher->teacher_calendar, 'Category image', ['style'=>'width: 100%; max-width: 150px; height: 150px;']) !!} </span>
                 @endif

          </div><!-- ./col -->
     </div><!-- /.row -->
      @endif
      <!-- Main row -->
    </section><!-- /.content -->
@stop
