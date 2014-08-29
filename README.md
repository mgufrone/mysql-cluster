## Laravel Database Failover Connections

This package is for laravel database failover. It provides web-based interface for you to define your configurations

## Installation

Add this code at your `composer.json` file
```json
  {
    "require":{
      ...
      "gufy/mysql-cluster":"dev-master",
      ...
    },
    "repositories":[
      ...
      {
        "type":"github",
        "url":"https://github.com/mgufrone/mysql-cluster.git"
      }
      ...
    ]
  }
```


Add this service provider to your `app/config/app.php`'s provider section

```php
'Gufy\MysqlCluster\MysqlClusterServiceProvider',

```

Publish configuration using this command

```shell
php artisan config:publish gufy/mysql-cluster
```

Modify `app/config/packages/gufy/mysql-cluster/users.php`. This file will be used as authentication when you access admin area of mysql cluster

And then, start your server with `php artisan serve`. go to <http://localhost:8000/mysql-admin/clusters>

After you provide some connections, on your command prompt, run this to see it will be change the default connecction once your default server is down.

```shell
php artisan mysql-cluster:check
```

When in production server, you can use `supervisor` to run this command simultaneously. 
