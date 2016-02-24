@extends('user.main')

@section('content')
<div class="content-wrapper" style="min-height: 449px;">
    <div class="container">
        <div class="col-md-12">
            <div class="box">
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                </ol>
                <div class="row">
                    <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3>{!! $users->count() !!}</h3>
                                <p>Total Users</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person"></i>
                            </div>
                            <a href="{!! route('user.list.index') !!}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div><!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>{!! $words->count() !!}</h3>
                                <p>Total Words</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{!! route('user.words.index') !!}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div><!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3>{!! $categories->count() !!}</h3>
                                <p>Total Categories</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{!! route('user.categories.index') !!}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div><!-- ./col -->
                </div><!-- /.row -->
                <div class="row">
                    <div class="tab-pane active" id="timeline">
                        <!-- The timeline -->
                        <ul class="timeline timeline-inverse">
                            <!-- timeline time label -->
                            @foreach($filterActivities as $date => $activities)
                                <li class="time-label">
                                    <span class="bg-green">
                                        {!! Date('jS \of F Y', strtotime($date)) !!}
                                    </span>
                                </li>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                @foreach($activities as $activity)
                                    <li>
                                        @if ($activity->checkTypeLesson())
                                            <i class="fa fa-book bg-blue"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fa fa-clock-o"></i> {!! Date('h:i', strtotime($activity->created_at)) !!}</span>
                                            <h3 class="timeline-header">
                                                <a href="{!! route('user.profiles.show', $activity->lesson->user->id) !!}">{!! $activity->lesson->user->name !!}</a>
                                                Passed {!! $activity->lesson->countPassed()->count() !!} / {!! \App\Models\Lesson::QUESTION_PER_LESSON !!}
                                                in <a href="{!! route('user.results.show', $activity->lesson->id) !!}">Lesson  of the {!! $activity->lesson->category->name !!}</a>
                                            </h3>
                                        </div>
                                        @elseif ($activity->checkTypeFollow())
                                            <i class="fa fa-user bg-blue"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="fa fa-clock-o"></i> {!! Date('h:i', strtotime($activity->created_at)) !!}</span>
                                                <h3 class="timeline-header">
                                                    <a href="{!! route('user.profiles.show', $activity->follow->follower->id) !!}">{!! $activity->follow->follower->name !!}</a>
                                                    Followed <a href="{!! route('user.profiles.show', $activity->follow->followee->id) !!}">{!! $activity->follow->followee->name !!}</a>
                                                </h3>
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            @endforeach
                            <!-- END timeline item -->
                            <li>
                                <i class="fa fa-clock-o bg-gray"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
      <!-- Main row -->
</div> <!-- /.content -->
@stop