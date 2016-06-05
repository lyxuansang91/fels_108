<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\Semester;
use App\Models\SemesterSubjectLevel;
use App\Models\Conduct;
use App\Models\Point;
use App\Models\Subject;
use App\Models\Level;
use App\Models\Teacher;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
