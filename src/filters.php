<?php

Route::filter('cluster', function(){
		Config::set('auth.driver', 'file');
		Config::set('laravel-auth-file-driver::users', Config::get('mysql-cluster::users'));
	if(Auth::guest()) return Redirect::route('mysql-cluster.login');
});
