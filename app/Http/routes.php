<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/



// Authentication routes...
Route::get('/admin/auth/login', ['as'=>'admin.login', 'uses'=>'Admin\Auth\AuthController@getLogin']);
Route::post('/admin/auth/login', 'Admin\Auth\AuthController@postLogin');
Route::get('/admin/auth/logout', ['as'=>'admin.logout', 'uses'=>'Admin\Auth\AuthController@getLogout']);


/**
 * ADMIN PANEL ROUTES
 */
Route::group(['middleware' => 'auth'], function () {

	Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin'], function () {

		Route::get('/', 'DashboardController@index');

		Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
		Route::get('dashboard/publish/staging', ['as'=>'dashboard.publish.staging', 'uses'=>'DashboardController@publishToStaging']);
		Route::get('dashboard/publish/production', ['as'=>'dashboard.publish.production', 'uses'=>'DashboardController@publishToProduction']);

		Route::get('users/ajax', 'UserController@getUsers');
		Route::get('users/edit/{id}/user', 'UserController@getUser');
		Route::resource('users', 'UserController');

		Route::get('issuers/ajax', ['as'=>'issuers.ajax', 'uses'=>'IssuerController@getissuers']);
		Route::get('issuers/edit/issuer/{id}', ['as'=>'issuers.edit.ajax', 'uses'=>'IssuerController@getIssuer']);
		Route::put('issuers/{id}/issuer/status', 'IssuerController@updateStatus');
		Route::resource('issuers', 'IssuerController');

		Route::get('content-blocks', ['as' => 'content-blocks', 'uses' => 'ContentBlockController@index']);
		Route::get('content-blocks/list', ['as' => 'content-blocks.list', 'uses' => 'ContentBlockController@getContentBlocksList']);
		Route::get('content-blocks/ajax', ['as' => 'content-blocks.ajax', 'uses' => 'ContentBlockController@getContentBlocksAjax']);
		Route::get('content-blocks/create', ['as' => 'content-blocks.create', 'uses' => 'ContentBlockController@create']);
		Route::post('content-blocks/store', ['as' => 'content-blocks.store', 'uses' => 'ContentBlockController@store']);
		Route::delete('content-blocks/{id}', ['as' => 'content-blocks.delete', 'uses' => 'ContentBlockController@destroy']);
		Route::get('content-blocks/{id}', ['as' => 'content-blocks.edit', 'uses' => 'ContentBlockController@edit']);
		Route::get('content-blocks/edit/ajax/{id}', ['as' => 'content-blocks.edit.ajax', 'uses' => 'ContentBlockController@getContentBlock']);
		Route::put('content-blocks/update/{id}', ['as' => 'content-blocks.update', 'uses' => 'ContentBlockController@update']);

		Route::get('templates', ['as' => 'templates', 'uses' => 'TemplateController@index']);
		Route::get('templates/ajax', 'TemplateController@getTemplatesAjax');
		Route::get('templates/create', ['as' => 'templates.create', 'uses' => 'TemplateController@create']);

		Route::get('pages', ['as' => 'pages', 'uses' => 'PageController@index']);
		Route::get('pages/ajax', 'PageController@getPagesAjax');
		Route::get('pages/create', ['as' => 'pages.create', 'uses' => 'PageController@create']);
		Route::post('pages/store', ['as' => 'pages.store', 'uses' => 'PageController@store']);
		Route::get('pages/edit/{id}', ['as' => 'pages.edit', 'uses' => 'PageController@edit']);
		Route::get('pages/edit/page/{id}', ['as' => 'pages.edit.page', 'uses' => 'PageController@getPage']);
		Route::put('pages/update/{id}', ['as' => 'pages.update', 'uses' => 'PageController@update']);
		Route::get('pages/show/{id}', ['as' => 'pages.show', 'uses' => 'PageController@show']);
		Route::get('pages/{id}', ['as' => 'page', 'uses' => 'PageController@getPage']);
		Route::delete('pages/{id}', ['as' => 'pages.delete', 'uses' => 'PageController@destroy']);
		Route::get('pages/cards/{id}', ['as' => 'pages.cards', 'uses' => 'PageController@showCardAssignments']);
		Route::get('pages/assigned-cards/{id}', ['as' => 'pages.assigned-cards', 'uses' => 'PageController@assignedCards']);
		Route::put('pages/assign-cards/{id}', ['as' => 'pages.assign-cards', 'uses' => 'PageController@assignCards']);
		Route::put('pages/assigned-cards/order/{id}', ['as' => 'pages.assigned-cards.order', 'uses' => 'PageController@order']);
		Route::put('pages/unassign-card/{id}', ['as'=>'pages.unassigned-card', 'uses'=>'PageController@unAssignCard']);
		Route::get('pages/content-blocks/{id}', ['as'=>'pages.content-blocks', 'uses'=>'PageController@showContentAssignments']);
		Route::get('pages/assigned-content-blocks/{id}', ['as'=>'pages.assigned-content', 'uses'=>'PageController@assignedContent']);
		Route::put('pages/assign-content-block/{id}', ['as' => 'pages.assign-content', 'uses' => 'PageController@assignContent']);
		Route::put('pages/unassign-content-block/{id}', ['as'=>'pages.unassigned-content', 'uses'=>'PageController@unAssignContent']);
		Route::put('pages/{id}/page/status', 'PageController@updateStatus');

		Route::get('static/pages/all', 'StaticPageController@getPages');
		Route::get('static/pages/{id}/page', 'StaticPageController@getPage');
		Route::resource('static/pages', 'StaticPageController');

		Route::get('categories/ajax', 'CategoryController@getCategories');
		Route::get('categories/{id}/category', 'CategoryController@getCategory');
		Route::put('categories/{id}/category/status', 'CategoryController@updateStatus');
		Route::resource('categories', 'CategoryController');

		Route::get('cards/list', ['as' => 'cards.list', 'uses' => 'CardController@getCardsList']);
		Route::get('cards/ajax', ['as' => 'cards.ajax', 'uses' => 'CardController@getCards']);
		Route::get('cards/{id}/card', 'CardController@getCard');
		Route::put('cards/{id}/card/status', 'CardController@updateStatus');
		Route::resource('cards', 'CardController');

		Route::get('nodes/ajax', ['as' => 'nodes.ajax', 'uses' => 'NodeController@getNodes']);
		Route::post('nodes/store', ['as' => 'nodes.store', 'uses' => 'NodeController@store']);
		Route::delete('nodes/delete/{id}', ['as' => 'nodes.delete', 'uses' => 'NodeController@destroy']);

		Route::get('code/{id}/ajax', 'CodeController@getCode');
		Route::resource('code', 'CodeController');

		Route::get('feeds/ajax', ['as' => 'feeds.ajax', 'uses' => 'FeedController@getFeeds']);
		Route::get('feeds/{id}/feed', 'FeedController@getFeed');
		Route::get('feeds/pull/{id}/cards', ['as' => 'feeds.pull.cards', 'uses' => 'FeedController@pullCardsFromFeed']);
		Route::get('feeds/pull/{id}/issuers', ['as' => 'feeds.pull.issuers', 'uses' => 'FeedController@pullIssuersFromFeed']);
		Route::get('feeds/pull/{id}/categories', ['as' => 'feeds.pull.categories', 'uses' => 'FeedController@pullCategoriesFromFeed']);
		Route::resource('feeds', 'FeedController');

		Route::get('reviews/issuers','ReviewController@issuerReviews');
		Route::get('reviews/issuers/all', 'ReviewController@getIssuerReviews');
		Route::get('reviews/issuer/{id}', 'ReviewController@getReviewsByIssuer');
		Route::get('reviews/issuer/{id}/count', 'ReviewController@getReviewCountByIssuer');
		Route::delete('reviews/issuer/{id}', 'ReviewController@deleteReviewsByIssuer');
		Route::get('reviews/products', 'ReviewController@productReviews');
		Route::get('reviews/products/all', 'ReviewController@getProductReviews');
		Route::get('reviews/product/{id}', 'ReviewController@getReviewsByProduct');
		Route::get('reviews/product/{id}/count', 'ReviewController@getReviewCountByProduct');
		Route::delete('reviews/product/{id}', 'ReviewController@deleteReviewsByProduct');
		Route::get('reviews/maps', 'ReviewController@map');
		Route::get('reviews/maps/all', 'ReviewController@getMappings');
		Route::get('reviews/maps/create', 'ReviewController@createMap');
		Route::post('reviews/maps', 'ReviewController@storeMap');
		Route::get('reviews/maps/{id}/edit', 'ReviewController@editMap');
		Route::get('reviews/maps/{id}', 'ReviewController@getMap');
		Route::put('reviews/maps/{id}', 'ReviewController@updateMap');
		Route::delete('reviews/maps/{id}', 'ReviewController@deleteMap');
		Route::get('reviews/parsers', 'ReviewController@parsers');
		Route::get('reviews/parsers/all', 'ReviewController@getParsers');
		Route::get('reviews/parsers/create', 'ReviewController@createParser');
		Route::post('reviews/parsers', 'ReviewController@storeParser');
		Route::delete('reviews/parsers/{id}', 'ReviewController@deleteParser');

		Route::get('reviews/upload', 'ReviewController@upload');
		Route::post('reviews/processUpload', 'ReviewController@processUpload');
		Route::get('reviews/staff-reviews/product/{id}', 'StaffReviewController@getStaffReviewByProduct');
		Route::get('reviews/jobs', 'FileController@getJobs');

		Route::get('/media/all', 'MediaController@getMedia');
		Route::get('/media/upload', 'MediaController@upload');
		Route::post('/media/process-uploads', 'MediaController@processUploads');
		Route::resource('media', 'MediaController');

		Route::get('/help', ['as' => 'help', 'uses' => 'SiteController@help']);

	});
});