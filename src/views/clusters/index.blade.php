@section('content')

<a href="{{route('mysql-admin.clusters.create')}}" class="btn pull-right btn-success"><i class="glyphicon glyphicon-plus"></i> Create Connection</a>
<div class="clearfix"></div>
<table class="table table-bordered table-striped" ng-controller="ClusterController as cluster" ng-app="clusters">
  <thead>
    <tr>
      <th>Connection Name</th>
      <th>Default Host</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @if(0===count($clusters->connections))
    <tr>
      <td class="text-center" colspan="3">No Connections found</td>
    </tr>
    @endif
    @foreach($clusters->connections as $name=>$cluster)
    <tr>
      <td>{{$name}}</td>
      <td>
        @foreach($cluster->config as $host)
        @if(isset($host->default))
        {{$host->host}}
        <?php
        break;
        ?>
        @endif
        @endforeach
      </td>
      <td>
        <a href="{{route('mysql-admin.clusters.show', ['clusters'=>$name])}}" class="btn btn-info">Show</a>
        <a href="{{route('mysql-admin.clusters.edit', ['clusters'=>$name])}}" class="btn btn-info">Edit</a>
        <a href="{{route('mysql-admin.clusters.destroy', ['clusters'=>$name])}}" onclick="return false" ng-click="cluster.delete('{{route('mysql-admin.clusters.destroy', ['clusters'=>$name])}}');" class="btn btn-danger">Destroy</a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@stop
