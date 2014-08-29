<?php namespace Gufy\MysqlCluster;

class Mysql
{
  public function getConnections()
  {
    $path = \Config::get('mysql-cluster::config.path');
    $content = json_decode(\File::get($path), 1);
    foreach($content['connections'] as &$connect)
    {
      uasort($connect['config'], function($a, $b){
        return isset($a['default'])<isset($b['default']);
      });
    }
    return $content['connections'];
  }

  public function setConnection($key, $value)
  {
    $path = \Config::get('mysql-cluster::config.path');
    $content = json_decode(\File::get($path), 1);
    $content['connections'] = array_merge($content['connections'], array($key=>$value));
    \File::put($path, json_encode($content));
    return true;
  }

  public function removeConnection($key)
  {
    $path = \Config::get('mysql-cluster::config.path');
    $content = json_decode(\File::get($path), 1);
    unset($content['connections'][$key]);
    \File::put($path, json_encode($content));
    return true;
  }

  public function setDefaultConnection()
  {
    $connections = $this->getConnections();
    foreach($connections as $name=>&$config)
    {
      foreach($config['config'] as &$host)
      {
        if(isset($host['default']))
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

        }
      }
    }
    return $this;
  }

  public function save()
  {

  }
}
