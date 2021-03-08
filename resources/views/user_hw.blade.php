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
.btnoutline {
    border: 1.5px solid orange;
    background-color: white;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 5px !important;
    border-color: #ff9800 !important;
    color: orange;
}

.btnoutline:hover {
    background: #ff9800;
    color: white;
}
</style>
@stop

@section('content')
<div class="container">
  <br><br>
  <div class="panel-heading"><h4 style="text-align:center;"><i class="fas fa-lg fa-list-alt"></i>&nbsp;&nbsp;<strong>作 業 專 區</strong></h4></div>
  <div class="panel panel-default" >
    <div class="panel-body">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        @foreach($class_id as $key => $value)
          @foreach($school[$key] as $sch)
          <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#nav-{{$key}}" role="tab" aria-controls="home" aria-selected="true">{{$sch}}</a>
          </li>
          @endforeach
        @endforeach
      </ul>
      <div class="tab-content" id="myTabContent">
        @foreach($class_id as $key => $value)
        @foreach($school[$key] as $courId => $sch)

        <div class="tab-pane fade" id="nav-{{$key}}" role="tabpanel" aria-labelledby="home-tab">
            @foreach($chapters[$key] as $chap)
            <h2><span class="label label-default">{{$chap->title}}</h2>
              @foreach($sections[$key] as $sec)
              @if($sec->chapter_id==$chap->id)
              <h3 style="color:#808000;">&nbsp;&nbsp; {{$sec->title}}</h3>
                @foreach($questions[$key] as $ques)
                  @if($ques->section_id==$sec->id)
                  <a href="{{ url('compiler') }}?qid={{$ques->id}}" style="text-decoration:none;"><h3 style="color:#0088A8; font-size:23px; display:inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-file-code"></i>&nbsp;&nbsp;{{$ques->title}}</h3></a>&nbsp;&nbsp;
                  <a href="{{ url('userhw')}}/{{$courId}}/{{$ques->id}}"><button type="button" class="btn btn-warning btn-md btnoutline"><strong>提交</strong></button></a>
                  @foreach($due[$key] as $dues)
                    @if($dues->question_id==$ques->id)
                    <code>截止時間:@if(is_null($dues->due_date)) 無期限 @else {{$dues->due_date}} @endif</code>
                    @endif
                  @endforeach
                  <br>
                  @endif
                @endforeach
              @endif
              @endforeach
              <br>
            @endforeach
        </div>
        @endforeach
        @endforeach
      </div>
    </div>
  </div>
</div>

@section('js')
<script>
var selectedTab = 'nav-{{$key}}';
var selector = '#myTab a[href="#nav-{{$key}}"]'.replace('nav-{{$key}}', selectedTab);
$(selector).tab('show');
</script>
@stop

@endsection
