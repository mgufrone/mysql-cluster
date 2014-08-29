<?php namespace Gufy\MysqlCluster\Facades;

use Illuminate\Support\Facades\Facade;

class MysqlCluster extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'mysql.cluster'; }

}
