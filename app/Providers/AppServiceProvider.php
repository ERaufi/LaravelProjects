<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    //     DB::listen(function ($query) {
    //         // Get the call stack
    //         $stack = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

    //         // Filter out vendor directory calls
    //         foreach ($stack as $call) {
    //             if (isset($call['file']) && strpos($call['file'], 'vendor') === false) {
    //                 $controllerFile = $call['file'];
    //                 $controllerLine = $call['line'];

    //                 // Remove the specific part from the file path
    //                 $controllerFile = str_replace('C:\Users\Edris Raufi\Desktop\laravel project\LaravelProjects', '', $controllerFile);

    //                 break;
    //             }
    //         }

    //         $bindings = implode(", ", $query->bindings); // Format the bindings as a string
    //         Log::info("
    //    ------------
    //    Sql: $query->sql
    //    Bindings: $bindings
    //    Time: $query->time
    //    Controller: $controllerFile
    //    Line: $controllerLine
    //    ------------
    // ");
    //     });
    }
}
