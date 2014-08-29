<?php namespace Gufy\MysqlCluster\Controllers;
use Redirect;
use Auth;
use Response;
use View;
use Input;
use Config;
use MysqlCluster;

class ClusterController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public $layout = 'mysql-cluster::layouts.layout';
	public function index()
	{
		//
		$this->layout->title = 'Clusters';
		$clusters = json_decode(file_get_contents(Config::get('mysql-cluster::config.path')));
		$this->layout->content = View::make('mysql-cluster::clusters.index', compact('clusters'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		$this->layout->title = 'Add Clusters';
		$clusters = json_decode(file_get_contents(Config::get('mysql-cluster::config.path')));
		$this->layout->content = View::make('mysql-cluster::clusters.create', compact('clusters'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		MysqlCluster::setConnection(Input::get('name'), [
				'database'=>Input::get('database'),
				'config'=>Input::get('config')
		]);

		return Redirect::route('mysql-admin.clusters.index');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
		$this->layout->title = 'Edit Cluster';
		$clusters = json_decode(file_get_contents(Config::get('mysql-cluster::config.path')), 1);
		$current_cluster = $clusters['connections'][$id];
		sort($current_cluster['config']);
		$current_cluster = (object)$current_cluster;
		$name = $id;
		$this->layout->content = View::make('mysql-cluster::clusters.edit', compact('clusters', 'current_cluster', 'name'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
		MysqlCluster::setConnection(Input::get('name'), [
				'database'=>Input::get('database'),
				'config'=>Input::get('config')
		]);

		return Redirect::route('mysql-admin.clusters.index');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
		MysqlCluster::removeConnection($id);

		return Response::json([
			'message'=>'connection removed',
			'result'=>'success',
		]);
	}


}
