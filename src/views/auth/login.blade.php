@section('content')
<div class="container" style="margin-top:30px">
  <div class="col-md-8 col-md-offset-2">
    <div class="login-panel panel panel-default">
      <div class="panel-heading">
          <h3 class="panel-title">{{trans('mysql-cluster::auth.title')}}</h3>
      </div>
      <div class="panel-body">
          @if(Session::has('error-message'))
          <div class="alert alert-danger">
            {{Session::get('error-message')}}
          </div>
          @endif
          {{Form::open(['url'=>route('mysql-cluster.login'),'method'=>'post'])}}
          <fieldset>
              <div class="form-group">
                  <input class="form-control" placeholder="{{trans('mysql-cluster::auth.email')}}" name="email" type="email" autofocus="">
              </div>
              <div class="form-group">
                  <input class="form-control" placeholder="{{trans('mysql-cluster::auth.password')}}" name="password" type="password" value="">
              </div>
              <!-- Change this to a button or input when using this as a form -->
              <button class="btn btn-sm btn-success pull-right" type="submit">{{trans('mysql-cluster::auth.submit')}}</button>
              <div class="clearfix"></div>
          </fieldset>
          {{Form::close()}}
      </div>
    </div>
  </div>
</div>

@stop
