@section('content')
<div class="container" style="margin-top:30px">
  <div class="col-md-8 col-md-offset-2">
    <div class="login-panel panel panel-default">
      <div class="panel-heading">
          <h3 class="panel-title">{{trans('mysql-cluster::clusters.update')}}</h3>
      </div>
      <div class="panel-body" ng-controller="ClusterController as cluster" ng-app="clusters" ng-init='cluster.clusters = {{json_encode($current_cluster->config)}}'>
          @if(Session::has('error-message'))
          <div class="alert alert-danger">
            {{Session::get('error-message')}}
          </div>
          @endif
          {{Form::open(['url'=>route('mysql-admin.clusters.update', ['clusters'=>$name]),'method'=>'put'])}}
          <fieldset>
              <div class="form-group">
                  <input class="form-control" placeholder="name" name="name" type="text" autofocus="" value="{{$name}}">
              </div>
              <div class="form-group">
                  <input class="form-control" placeholder="database name" name="database" type="text" autofocus="" value="{{$current_cluster->database}}">
              </div>
              <div class="hosts" ng-repeat="(key, config) in cluster.clusters">
                <span class="header">Host Config #@{{key+1}}</span>
                <a href="#" ng-click="cluster.remove(key);" ng-hide="config.default" class="btn btn-xs btn-danger pull-right"><i class="glyphicon glyphicon-trash"></i></a>
                <div class="form-group">
                    <input class="form-control" placeholder="host" name="config[@{{key}}][host]" ng-value="config.host">
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="username" name="config[@{{key}}][user]" ng-value="config.user">
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="password" name="config[@{{key}}][pass]" ng-value="config.pass">
                </div>
                <div class="form-group">
                    <label>
                      <input type="checkbox" ng-change="cluster.releaseDefault(key);" ng-checked="config.default" name="config[@{{key}}][default]" ng-model="config.default"> Set Default
                    </label>
                </div>
              </div>
              <!-- Change this to a button or input when using this as a form -->
              <button class="btn btn-sm btn-default" type="button" ng-click="cluster.add();"><i class="glyphicon glyphicon-plus"></i> {{trans('mysql-cluster::clusters.add-more')}}</button>
              <button class="btn btn-sm btn-success pull-right" type="submit">{{trans('mysql-cluster::clusters.save')}}</button>
              <div class="clearfix"></div>
          </fieldset>
          {{Form::close()}}
      </div>
    </div>
  </div>
</div>

@stop
