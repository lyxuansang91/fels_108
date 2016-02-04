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
                                            <b>Learned Word</b> <a class="pull-right">{!! $user->learnedWord()->count() !!}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Followers</b> <a class="pull-right">{!! $user->follows->count() !!}</a>
                                        </li>
                                        <li class="list-group-item">
                                          <b>Following</b> <a class="pull-right">{!! $user->following()->count() !!}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Activities</b> <a class="pull-right">{!! $user->activities->count() !!}</a>
                                        </li>
                                    </ul>
                                    @if(\Auth::id() == $user->id)
                                        <a href="{!! route('user.profiles.edit', \Auth::id()) !!}" class="btn btn-primary btn-block"><b>Update profile</b></a>
                                    @else
                                        @if($user->follows->count() < 1)
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
                                    <h3 class="box-title">About Me</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <strong><i class="fa fa-book margin-r-5"></i>  Education</strong>
                                    <p class="text-muted">
                                        B.S. in Computer Science from the University of Tennessee at Knoxville
                                    </p>

                                    <hr>

                                    <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
                                    <p class="text-muted">Malibu, California</p>

                                    <hr>

                                    <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>
                                    <p>
                                        <span class="label label-danger">UI Design</span>
                                        <span class="label label-success">Coding</span>
                                        <span class="label label-info">Javascript</span>
                                        <span class="label label-warning">PHP</span>
                                        <span class="label label-primary">Node.js</span>
                                    </p>

                                    <hr>

                                    <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                        <div class="col-md-9">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#activity" data-toggle="tab">Activity</a></li>
                                    <li><a href="#timeline" data-toggle="tab">Lesson's history</a></li>
                                    <li><a href="#settings" data-toggle="tab">Settings</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="active tab-pane" id="activity">
                                        <ul class="timeline timeline-inverse">
                                            @foreach($user->activities as $activity)
                                                <!-- timeline time label -->
                                                <li class="time-label">
                                                    @if($activity->checkTypeLesson())
                                                    <span class="bg-red">
                                                        {!! Date('jS \of F Y', strtotime($activity->created_at)) !!}
                                                    </span>
                                                    @elseif($activity->checkTypeFollow())
                                                    <span class="bg-green">
                                                        {!! Date('jS \of F Y', strtotime($activity->created_at)) !!}
                                                    </span>
                                                    @endif
                                                </li>
                                                <!-- /.timeline-label -->
                                                <li>
                                                    @if($activity->checkTypeLesson())
                                                        <i class="fa fa-book bg-blue"></i>
                                                    @elseif($activity->checkTypeFollow())
                                                        <i class="fa fa-user bg-blue"></i>
                                                    @endif
                                                    <div class="timeline-item">
                                                        <h3 class="timeline-header">{!! $activity->content !!}</h3>
                                                    </div>
                                                </li>
                                            @endforeach
                                            <li>
                                                <i class="fa fa-clock-o bg-gray"></i>
                                            </li>
                                        </ul>
                                    </div><!-- /.tab-pane -->
                                    <div class="tab-pane" id="timeline">
                                        @foreach($user->lessons as $lesson)
                                            <div class="post">
                                                <div class="user-block">
                                                    <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
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

                                    <div class="tab-pane" id="settings">
                                        <form class="form-horizontal">
                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-2 control-label">Name</label>
                                                <div class="col-sm-10">
                                                    <input type="email" class="form-control" id="inputName" placeholder="Name">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-2 control-label">Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="inputName" placeholder="Name">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputExperience" class="col-sm-2 control-label">Experience</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputSkills" class="col-sm-2 control-label">Skills</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" class="btn btn-danger">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div><!-- /.tab-pane -->
                                </div><!-- /.tab-content -->
                            </div><!-- /.nav-tabs-custom -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>
@stop