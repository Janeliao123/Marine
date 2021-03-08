@extends('layout.layout')

@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<style>
.panel-heading {
    background-color: #5F9EA0;
    color: #fff;
}
.tab-content{
    padding-left: 30px;
}
</style>
@stop

@section('content')
<div class="container">
  <br><br>
  <div class="panel-heading"><h4 style="text-align:center;"><i class="far fa-lg fa-file-code"></i>&nbsp;&nbsp;<strong>作 業 專 區</strong></h4></div>
  <div class="panel panel-default" >
    <div class="panel-body" style="text-align:center;">
        <h2><span class="label label-danger">尚未新增作業!</h2>
    </div>    
  </div>
  </div>              
</div>
  
@endsection