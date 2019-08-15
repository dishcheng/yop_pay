<?php

namespace DishCheng\YopPay;


use Illuminate\Support\ServiceProvider;


class YopPayProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {

    }

    public function register()
    {
        $this->app->singleton('yop_pay', function () {
            return new YopPay();
        });
    }
}
