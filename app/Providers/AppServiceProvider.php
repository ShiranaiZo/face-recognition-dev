<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

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
        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });

        Validator::replacer('without_spaces', function ($message, $attribute, $rule, $parameters) {
            $newMessage =  'The '. $attribute . ' cannot contain spaces.';
            return str_replace($message, $newMessage, $message);
        });
    }
}
