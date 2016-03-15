<?php
/**
 * Created by PhpStorm.
 * User: davidc
 * Date: 12/28/15
 * Time: 9:21 AM
 */

namespace Modules;

class ServiceProvider extends \Illuminate\Support\ServiceProvider {

    public function boot()
    {
        $modules = config("modules.modules");
        while (list(,$module) = each($modules)) {

            if(file_exists(__DIR__.'/'.$module.'/routes.php')) {
                include __DIR__.'/'.$module.'/routes.php';
            }
            if(is_dir(__DIR__.'/'.$module.'/Views')) {
                $this->loadViewsFrom(__DIR__.'/'.$module.'/Views', $module);
            }
        }
    }
    public function register(){}

}