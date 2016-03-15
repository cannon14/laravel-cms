<?php
/**
 * Created by PhpStorm.
 * User: davidc
 * Date: 12/28/15
 * Time: 9:23 AM
 */

namespace Modules\ProductFeedModule;

class ServiceProvider extends \Modules\ServiceProvider {

    public function register()
    {
        parent::register('ProductFeedModule');
    }

    public function boot()
    {
        parent::boot('ProductFeedModule');
    }

}