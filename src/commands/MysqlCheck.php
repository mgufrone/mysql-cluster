<?php namespace Gufy\MysqlCluster\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use MysqlCluster;

class MysqlCheck extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'mysql-cluster:check';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Checking active mysql connections';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		//
		while(true)
		{

			$connections = MysqlCluster::getConnections();
			// echo json_encode($connections);
			// exit(0);
			foreach($connections as $name=>&$config)
			{
				foreach($config['config'] as &$host)
				{
					try
					{
						\Config::set('database.connections.'.$name, array(
							'driver'    => 'mysql',
							'host'      => $host['host'],
							'database'  => $config['database'],
							'username'  => $host['user'],
							'password'  => $host['pass'],
							'charset'   => 'utf8',
							'collation' => 'utf8_unicode_ci',
							'prefix'    => '',
						));
						\DB::connection($name)->statement('SELECT 1');

						if(isset($host['default']))
						{
							$this->info('Default Connection \''.$name.'\' with host '.$host['host'].' is up. No need to worry');
							break;
						}
						else
						{
							$this->info('Connection \''.$name.'\' with host '.$host['host'].' is up');
							$host['default'] = 'true';
						}
						\DB::disconnect($name);
					}
					catch(\Exception $e)
					{
						if(isset($host['default']))
						{
							unset($host['default']);
							$this->error('Default Connection \''.$name.'\' with host '.$host['host'].' is down. Try to change default connection');
						}
						else
							$this->error('Connection \''.$name.'\' with host '.$host['host'].' is down');
						$this->error('Message : '.$e->getMessage());
						\DB::disconnect($name);
					}
				}
				MysqlCluster::setConnection($name, $config);
			}
			sleep(3);
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			// array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			// array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
