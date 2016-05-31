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
                                    <img class="profile-user-img img-responsive img-circle" src="{!! asset($user->avatar) !!}" alt="User profile picture" style="width: 100%; max-width: 100px; height: 100px;">
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
                            <table id="example1" class="table table-bordered table-striped">
                                @if (count($points) > 0)
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Semester Name</th>
                                            <th>Subject Name</th>
                                            <th>Group Name</th>
                                            <th>Level Name</th>
                                            <th>User Name</th>
                                            <th>Mark M 1</th>
                                            <th>Mark M 2</th>
                                            <th>Mark M 3</th>
                                            <th>Mark M 4</th>
                                            <th>Mark 15 1</th>
                                            <th>Mark 15 2</th>
                                            <th>Mark 15 3</th>
                                            <th>Mark 45 1</th>
                                            <th>Mark 45 2</th>
                                            <th>Mark Last</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($points as $point)
                                        <tr>
                                            <td>{{{ $point->id }}}</td>
                                            <td>{!! nl2br($point->semester_subject_group->semester->name) !!}</td>
                                            <td>{{{ $point->semester_subject_group->subject->subject_name }}}</td>
                                            <td>{{{ $point->semester_subject_group->group->group_name }}}</td>
                                            <td>{{{ $point->semester_subject_group->level->level_name }}}</td>
                                            <td>{{{ $point->user->student->name }}}</td>
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
