<?php

namespace App\Repositories\Eloquents;

use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('App\Repositories\UserRepositoryInterface', function() {
            return new \App\Repositories\Eloquents\UserRepository(\App\Models\User::class);
        });

        $this->app->bind('App\Repositories\WordRepositoryInterface', function() {
            return new \App\Repositories\Eloquents\WordRepository(\App\Models\Word::class);
        });

        $this->app->bind('App\Repositories\CategoryRepositoryInterface', function() {
            return new \App\Repositories\Eloquents\CategoryRepository(\App\Models\Category::class);
        });

        $this->app->bind('App\Repositories\FollowRepositoryInterface', function() {
            return new \App\Repositories\Eloquents\FollowRepository(\App\Models\Follow::class);
        });

        $this->app->bind('App\Repositories\LessonRepositoryInterface', function() {
            return new \App\Repositories\Eloquents\LessonRepository(\App\Models\Lesson::class);
        });

        $this->app->bind('App\Repositories\LessonWordRepositoryInterface', function() {
            return new \App\Repositories\Eloquents\LessonWordRepository(\App\Models\LessonWord::class);
        });

        $this->app->bind('App\Repositories\GradeRepositoryInterface', function() {
            return new \App\Repositories\Eloquents\GradeRepository(\App\Models\Grade::class);
        });

        $this->app->bind('App\Repositories\SemesterRepositoryInterface', function() {
            return new \App\Repositories\Eloquents\SemesterRepository(\App\Models\Semester::class);
        });

        $this->app->bind('App\Repositories\SubjectRepositoryInterface', function() {
            return new \App\Repositories\Eloquents\SubjectRepository(\App\Models\Subject::class);
        });

        $this->app->bind('App\Repositories\GroupRepositoryInterface', function() {
            return new \App\Repositories\Eloquents\GroupRepository(\App\Models\Group::class);
        });

        $this->app->bind('App\Repositories\LevelRepositoryInterface', function() {
            return new \App\Repositories\Eloquents\LevelRepository(\App\Models\Level::class);
        });

        $this->app->bind('App\Repositories\SemesterSubjectGroupRepositoryInterface', function() {
            return new \App\Repositories\Eloquents\SemesterSubjectGroupRepository(\App\Models\SemesterSubjectGroup::class);
        });

        $this->app->bind('App\Repositories\UserGroupRepositoryInterface', function() {
            return new \App\Repositories\Eloquents\UserGroupRepository(\App\Models\UserGroup::class);
        });
    }
}
