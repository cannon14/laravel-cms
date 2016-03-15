<?php
/**
 * Created by PhpStorm.
 * User: davidc
 * Date: 12/28/15
 * Time: 9:27 AM
 */

Route::group(['middleware' => 'auth'], function () {

    Route::group(['module' => 'reviews', 'prefix' => 'admin', 'namespace' => 'Modules\ProductReviewsModule\Controllers'], function () {

        Route::get('reviews/issuers/{issuer_id}/changeStatus', 'IssuerController@changeStatus');
        Route::resource('/reviews/issuers', 'IssuerController');

        Route::get('reviews/products/{product_id}/changeStatus', 'ProductController@changeStatus');
        Route::resource('reviews/products', 'ProductController');

        Route::resource('reviews/staff_reviews', 'StaffReviewController');

        Route::resource('reviews/jobs', 'JobController');

        Route::get('reviews/flush', 'SiteController@flushCache');
        Route::get('reviews/delete', 'SiteController@deleteAllJobs');

        Route::post('reviews/upload', 'FileController@uploadFile');
        Route::get('reviews', 'FileController@index');
    });
});