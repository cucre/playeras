<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('unique_unsensitive', function ($attribute, $value, $parameters, $validator){
            $query = DB::table($parameters[0])
                        ->where($parameters[1],'ILIKE',$value)
                        ->whereNull('deleted_at');

            if(isset($parameters[2])){
                $query = $query->where($parameters[1],'!=',$parameters[2]);
            }

            $query = $query->get();
            //dd($query->count() > 0);
            return $query->count() == 0;
        });

        \Validator::extend('check_stock', function ($attribute, $value, $parameters, $validator) {
            $query = DB::table($parameters[0])
                        ->where($parameters[1], $parameters[3])
                        ->first();

            if(empty($query)) {
                return false;
            }

            if($query->stock < $value) {
                return false;
            }

            return true;
        });
    }
}