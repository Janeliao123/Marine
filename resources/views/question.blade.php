@extends('layout.layout')

@section('css')
@section('css')
<style media="screen">
 .list-group-item-top{
   background-color:#3e87b9;
 }
 .row{
   margin-top: 30px;
 }
 .panel-header-wh{
   padding: 10px;

 }
 .back_btn{
   background-color: #f4511e;
   border: none;
   color: white;
   padding: 16px 32px;
   text-align: center;
   opacity: 0.6;
   transition: 0.3s;
   /* box-shadow: 7px 7px 5px #e6e6e6; */
 }
 .back_btn:hover{
   opacity: 1
 }
 a {
  text-decoration: none!important;/* no underline */
}
</style>
@endsection

@section('content')
<div class="container-body">
  <div class="row">
      <div class="col-sm-2 " >
        <div><a href=""><div class="back_btn panel">做&nbsp;題&nbsp;去&nbsp;<i class="fa fa-arrow-right" style="font-size:15px"></i></div></a></div>
        <div class="panel-group w3-card">
          <div class="panel">
                <div class="panel-heading" >
                  <h4 class="panel-title">
                    <a data-toggle="collapse" href="#"><h5>難易度</h5></a>
                  </h4>
                </div>
                <div class="panel-collapse collapse in">
                      <div class="panel-body">
                        @if($question->difficulty == 3)
                          <span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span>
                        @elseif($question->difficulty == 2)
                          <span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star-empty"></span>
                        @else
                          <span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star-empty"></span><span class="glyphicon glyphicon-star-empty"></span>
                        @endif
                      </div>
                </div>
          </div>
        </div>
        <div class="panel-group w3-card">
          <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a href="{{ url('/section/'.$section->title.'/'.$section->chapter_id.'/'.$section->id) }}"><h5>{{ $section->title }}</h5></a>
                  </h4>
                </div>
                <div class="panel-collapse collapse in">
                  @foreach($questionAll as $questionAll)
                    @if($questionAll->section_id == $section->id)
                      <div class="panel-body"><a href="{{ url('/section/'.$questionAll->title.'/'.$questionAll->id ) }}"><h6>{{ $questionAll->title }}</h6></a></div>
                    @endif
                  @endforeach
                </div>
          </div>
        </div>
      </div>
      <div class="col-sm-8 ">
        <div class="panel-group w3-card">
          <div class="panel">
                <div class="panel-header-wh">
                  <h3 class="panel-title">
                    <h3 style="font-weight: bold;border-left:solid 4px #92b5cf;">&nbsp;{{ $question->title }}</h3>
                  </h3>
                </div>
                <div class="panel-collapse collapse in">
                  <p>{!!$question->content!!}</p>
                </div>

          </div>
        </div>
      </div>
  </div>
  <img src="/img/seaa.png" style="width:8%; position: absolute; bottom:0px;right:0px;">

</div>
@endsection
