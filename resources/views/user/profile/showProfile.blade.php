@extends('user.main')

@section('content')
    <!-- Main content -->
    {{-- <section class="content"> --}}
    <div class="content-wrapper" style="min-height: 449px;">
        <div class="container">
            <div class="col-md-12">
                <div class="box">
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Profile</li>
                    </ol>
                    <div class="row">
                        <div class="col-md-3">
                            <!-- Profile Image -->
                            <div class="box box-primary">
                                <div class="box-body box-profile">
                                    <img class="profile-user-img img-responsive img-circle" src="{!! $user->avatar !!}" alt="User profile picture" style="width: 100%; max-width: 100px; height: 100px;">
                                    <h3 class="profile-username text-center">{!! $user->name !!}</h3>

                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <a href="{!! route('user.learned-words.show', $user->id) !!}"><b>Learned Word</b></a> 
                                            <a class="pull-right">{!! $user->learnedWord()->count() !!}</a>
                                        </li>
                                        <li class="list-group-item">
                                             
                                            <a href="{!! route('user.follows.show', $user->id) !!}"><b>Followers</b></a> 
                                            <a class="pull-right">{!! $user->follows->count() !!}</a>
                                        </li>
                                        <li class="list-group-item">
                                           
                                            <a href="{!! route('user.follows.show', $user->id) !!}"><b>Following</b></a> 
                                          <a class="pull-right">{!! $user->following()->count() !!}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Activities</b> <a class="pull-right">{!! $user->activities->count() !!}</a>
                                        </li>
                                    </ul>
                                    @if (auth()->id() == $user->id)
                                        <a href="{!! route('user.profiles.edit', \Auth::id()) !!}" class="btn btn-primary btn-block"><b>Update profile</b></a>
                                    @else
                                        @if ($user->checkfollowed()->count() < 1)
                                            {!! Form::open(['route' => 'user.follows.store']) !!}
                                                {!! Form::submit('Follow', ['class' => 'btn btn-primary btn-block']) !!}
                                                {!! Form::hidden('id', $user->id) !!}
                                            {!! Form::close() !!}
                                        @else
                                            {!! Form::open(['route' => ['user.follows.destroy', $user->id], 'method' => 'delete']) !!}
                                                {!! Form::submit('Unfollow', ['class' => 'btn btn-primary btn-block']) !!}
                                            {!! Form::close() !!}
                                        @endif
                                    @endif
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                            <!-- About Me Box -->
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Member</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                @foreach($listUser as $anUser)
                                    <strong>
                                        <a href="{!! route('user.profiles.show', $anUser->id) !!}">
                                            <i class="fa fa-user margin-r-5"></i> {!! $anUser->name !!}
                                        </a>
                                    </strong>
                                    <hr>
                                @endforeach
                                {!! $listUser->render() !!}
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                        <div class="col-md-9">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    @if (count($errors) > 0 || session()->has('messages'))
                                        <li><a href="#activity" data-toggle="tab">Activity</a></li>
                                        <li><a href="#timeline" data-toggle="tab">Lesson's history</a></li>
                                        @if (auth()->id() == $user->id)
                                            <li class="active"><a href="#settings" data-toggle="tab">Change Password</a></li>
                                        @endif
                                    @else
                                        <li class="active"><a href="#activity" data-toggle="tab">Activity</a></li>
                                        <li><a href="#timeline" data-toggle="tab">Lesson's history</a></li>
                                        @if (auth()->id() == $user->id)
                                            <li><a href="#settings" data-toggle="tab">Change Password</a></li>
                                        @endif
                                    @endif
                                </ul>
                                <div class="tab-content">
                                    @if (count($errors) > 0 || session()->has('messages'))
                                    <div class="tab-pane" id="activity">
                                    @else
                                    <div class="active tab-pane" id="activity">
                                    @endif
                                        <ul class="timeline timeline-inverse">
                                            @foreach ($user->activities()->paginate(\App\Models\Activity::ACTIVITIES_PER_PAGE) as $activity)
                                                <!-- timeline time label -->
                                                <li class="time-label">
                                                    @if ($activity->checkTypeLesson())
                                                    <span class="bg-red">
                                                        {!! Date('jS \of F Y', strtotime($activity->created_at)) !!}
                                                    </span>
                                                    @elseif ($activity->checkTypeFollow())
                                                    <span class="bg-green">
                                                        {!! Date('jS \of F Y', strtotime($activity->created_at)) !!}
                                                    </span>
                                                    @endif
                                                </li>
                                                <!-- /.timeline-label -->
                                                <li>
                                                    @if ($activity->checkTypeLesson())
                                                        <i class="fa fa-book bg-blue"></i>
                                                        <div class="timeline-item">
                                                            <h3 class="timeline-header">
                                                                Passed {!! $activity->lesson->countPassed()->count() !!} / {!! \App\Models\Lesson::QUESTION_PER_LESSON !!}
                                                                in <a href="{!! route('user.results.show', $activity->lesson->id) !!}">Lesson  of the {!! $activity->lesson->category->name !!}</a>
                                                            </h3>
                                                        </div>
                                                    @elseif ($activity->checkTypeFollow())
                                                        <i class="fa fa-user bg-blue"></i>
                                                        <div class="timeline-item">
                                                            <h3 class="timeline-header">
                                                                Followed <a href="{!! route('user.profiles.show', $activity->follow->followee->id) !!}">{!! $activity->follow->followee->name !!}</a>
                                                            </h3>
                                                        </div>
                                                    @endif
                                                </li>
                                            @endforeach
                                            <li>
                                                <i class="fa fa-clock-o bg-gray"></i>
                                            </li>
                                        </ul>
                                        {!! $user->activities()->paginate(\App\Models\Activity::ACTIVITIES_PER_PAGE)->render() !!}
                                    </div><!-- /.tab-pane -->
                                    <div class="tab-pane" id="timeline">
                                        @foreach ($user->lessons as $lesson)
                                            <div class="post">
                                                <div class="user-block">
                                                    <img class="img-circle img-bordered-sm" src="{!! $lesson->category->image !!}" alt="user image">
                                                    <span class='username'>
                                                        <a href="{!! route('user.results.show', $lesson->id) !!}">{!! $lesson->category->name !!}</a>
                                                    </span>
                                                    <span class='description'>{!! $lesson->created_at !!}</span>
                                                </div><!-- /.user-block -->
                                                <p>
                                                    {!! $lesson->content !!}
                                                </p>
                                            </div><!-- /.post -->
                                        @endforeach
                                    </div><!-- /.tab-pane -->
                                    @if (auth()->id() == $user->id)
                                        @if (count($errors) > 0 || session()->has('messages'))
                                        <div class="active tab-pane" id="settings">
                                        @else
                                        <div class="tab-pane" id="settings">
                                        @endif
                                        {!! Form::open(['route' => ['user.passwords.update', $user->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
                                            @if (count($errors) > 0)
                                                <div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{!! $error !!}</li>
                                                    @endforeach
                                                </div>
                                            @endif
                                            
                                            @if (session()->has('messages'))
                                                <div class="alert alert-warning alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                                    {!! session('messages') !!}
                                                </div>
                                            @endif
                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-3 control-label">Current Password</label>
                                                <div class="col-sm-9">
                                                    {!! Form::password('current_password', ['placeholder' => 'current password', 'class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-3 control-label">New Password</label>
                                                <div class="col-sm-9">
                                                    {!! Form::password('new_password', ['placeholder' => 'new password', 'class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-3 control-label">Confirm Password</label>
                                                <div class="col-sm-9">
                                                    {!! Form::password('new_password_confirm', ['placeholder' => 'confirm new password', 'class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-9">
                                                    <button type="submit" class="btn btn-danger">Submit</button>
                                                </div>
                                            </div>
                                        {!! Form::close() !!}
                                    </div><!-- /.tab-pane -->
                                    @endif
                                </div><!-- /.tab-content -->
                            </div><!-- /.nav-tabs-custom -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>
@stop