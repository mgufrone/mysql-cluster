<?php

Route::group([
  'before'=>'cluster',
  'namespace'=>'Gufy\MysqlCluster\Controllers',
  'prefix'=>'mysql-admin',
  ], function(){
    Route::get('/',['as'=>'mysql-admin.index','uses'=>function(){
      return Redirect::route('mysql-admin.clusters.index');
    }]);
    Route::resource('clusters','ClusterController');
});

Route::group([
  'namespace'=>'Gufy\MysqlCluster\Controllers',
  'prefix'=>'mysql-auth',
], function(){
  Route::get('/login', ['as'=>'mysql-cluster.login', 'uses'=>'AuthController@login']);
  Route::post('/login', ['as'=>'mysql-cluster.login', 'uses'=>'AuthController@postLogin']);
  Route::get('/logout', ['as'=>'mysql-auth.logout', 'uses'=>'AuthController@logout']);

});
