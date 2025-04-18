<?php

namespace App\Providers;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
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
        JsonResource::withoutWrapping();
        Model::shouldBeStrict(!app()->isProduction());

        if (!app()->isProduction()) {
            DB::listen(function (QueryExecuted $query) {
                if ($query->time > 100) {
                    logger()
                        ->channel('telegram')
                        ->debug('Query longer than 1ms: ' . $query->sql, $query->bindings);
                }
            });

            DB::whenQueryingForLongerThan(
                CarbonInterval::seconds(5),
                function (QueryExecuted $query) {
                    logger()->channel('telegram')->debug('whenRequestLifecycleIsLongerThan:' . $query->sql, $query->bindings);
                }
            );
        }
    }
}
