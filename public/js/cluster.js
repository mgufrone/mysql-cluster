angular.module('clusters', [])
.controller('ClusterController', ['$http', '$log', '$scope', '$timeout', function($http, $log, $scope, $timeout){
  var cluster = this;
  cluster.clusters = [
    {
      host: '',
      user: '',
      pass: '',
      default: true,
    }
  ];
  cluster.add = function()
  {
    cluster.clusters.push({
        host: '',
        user: '',
        pass: '',
        default: false,
    });
  };
  cluster.remove = function(key)
  {
    cluster.clusters.splice(key, 1);
  };
  cluster.releaseDefault = function(id)
  {
    angular.forEach(cluster.clusters, function(value, key){
      if(id != key)
        value.default = false;
    });
  };
  cluster.delete = function(path)
  {
    if(confirm('Press ok to proceed'))
      {
        $http.delete(path).success(function(data){
          alert(data.message);
          if(data.result == 'success')
            $timeout(function(){
              document.location.reload();
            },3000);
        });
      }
  };
}]);
