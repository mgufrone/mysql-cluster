<?php namespace Gufy\MysqlCluster\Controllers;
use Redirect;
use Auth;
use Response;
use View;
use Input;
use Config;

class AuthController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public $layout = 'mysql-cluster::layouts.layout';
	public function login()
	{
		if(!Auth::guest())
			return Redirect::route('mysql-admin.index');
		$this->layout->title = 'Login';
		$this->layout->content = View::make('mysql-cluster::auth.login');
	}

	public function logout()
	{
		Auth::logout();
		return Redirect::route('mysql-cluster.login');
	}

	public function postLogin()
	{

		Config::set('auth.driver', 'file');
		Config::set('laravel-auth-file-driver::users', Config::get('mysql-cluster::users'));
		// return Response::json(Config::get('auth.driver'));
		$email = Input::get('email');
		$password = Input::get('password');
		if(Auth::attempt(['email'=>$email, 'password'=>$password]))
			return Redirect::route('mysql-admin.index');
		else
			return Redirect::back()->with('error-message', trans('mysql-cluster::auth.error-login'));
	}


}
