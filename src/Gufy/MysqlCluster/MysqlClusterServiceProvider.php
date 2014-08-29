<?php namespace Gufy\MysqlCluster;

use Illuminate\Support\ServiceProvider;

class MysqlClusterServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('gufy/mysql-cluster');
		$this->loadFiles();
	}

	public function loadFiles()
	{
		$files = [
			'routes',
			'filters',
		];

		foreach($files as $file)
		{
			$file = dirname(__FILE__).'/../../'.$file.'.php';
			if(file_exists($file)) include $file;
		}
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
		$this->app['mysql.cluster'] = $this->app->share(function(){
			return new Mysql;
		});
		$this->app['commands.mysql-check'] = $this->app->share(function($app){
			return new Commands\MysqlCheck($app);
		});
		$this->commands('commands.mysql-check');

  	$this->app->register('Lucor\Auth\AuthServiceProvider');
		$this->app->booting(function(){
				// first time file configuration
				if(!file_exists(\Config::get('mysql-cluster::config.path')))
				{
					\File::makeDirectory(dirname(\Config::get('mysql-cluster::config.path')), 0755, 1);
					$file = \File::put(\Config::get('mysql-cluster::config.path'), json_encode(['connections'=>[]]));
				}

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('MysqlCluster', 'Gufy\MysqlCluster\Facades\MysqlCluster');
				$connections = app('mysql.cluster')->setDefaultConnection(); 
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
