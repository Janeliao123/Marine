@extends('layout.layout')
@section('css')
<style media="screen">

.navbar {
    margin: 0;
    width: 100%;
    padding-top: 15px;
    padding-bottom: 15px;
    border: 0;
    border-radius: 0;
    margin-bottom: 0;
    font-size: 15px;
    letter-spacing: 5px;
    background-color:#fff;

 }
 .list-group-item-top{
   background-color:#435761;
 }
 .card1 .body1 {
   color: #444;
   padding: 20px;
   font-weight: 400;
 }
 .card1 {
     background: #fff;
     transition: .5s;
     border: 0;
     margin-bottom: 30px;
     /* border-radius: .55rem; */
     position: relative;
     width: 100%;
     box-shadow: 0 1px 2px 0 rgba(0,0,0,0.1);
 }
 .top_counter .icon {
     float: right;
     width: 90px;
     height: 100px;
     border: 1px solid #eee;
     border-radius: .55rem;
     margin-right: 4%;
     background-color: #26a69a;
     color: white;
     padding: 9%;
 }
 .top_counter .content {
     height: 110px;
 }
 .fa-user:before {
     content: "\f007";
 }
 .number{
   font-size: 24px;

 }
 .text{
   padding-top: 20%;
 }
 .row{
   margin: 5%;
 }
 .header-pink{
   background-color: #e16c6c;
   padding: 5px;
 }
 .header-green{
   background-color: #4dbca1;
   padding: 5px;
 }
 .header-blue{
   background-color: #72bbc6;
   padding: 5px;

 }
 a:visited, a:link, a:active{
     text-decoration: none;
     color: rgb(33, 33, 33);
 }
 a:hover{
   color:rgb(184, 59, 70);
 }

</style>

@endsection
@section('content')
@if( $nothing == 0)
  <div class="row">
    <div class="col-sm-8" style="text-align:center;" >
      @if(Auth::check())
        @if($flag==0)
        <div class="alert alert-warning">
          <strong>同學還不在榜上喔QAQ~趕快去答題吧</strong>
        </div>
        @else
        <div class="alert alert-success">
          <strong>能力值贏過了{{$rank_p}}%的人</strong>
          <strong>勤奮值贏過了:{{$rank2_p}}%的人</strong>
        </div>
        <div class="alert alert-warning">
          <strong>加入排行榜的人數為{{$c_user}}</strong>
        </div>
        @endif
      @endif
    </div>
  </div>
  <div class="row">
      <div class="col-lg-4 col-md-6">
        <div class="card1 top_counter">
          <div class="header-blue">
            <center><h3 style="color:#fff"><b>能&nbsp;&nbsp;力&nbsp;&nbsp;榜&nbsp;&nbsp;</b></h3></center>
          </div>
            <div class="body1">
              <ul style="list-style-type: none;">
                <?php $i=1; ?>
                @foreach($warrior_ability as $key=>$value)
                <li><b>{{$i}}</b>   {{ $value->name }} </li><hr>
                <?php $i=$i+1; ?>
                @endforeach
              </ul>
            </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="card1 top_counter">
          <div class="header-blue">
            <center><h3 style="color:#fff"><b>勤&nbsp;&nbsp;奮&nbsp;&nbsp;榜&nbsp;&nbsp;</b></h3></center>
          </div>
            <div class="body1">
              <ul style="list-style-type: none;">
                <?php $j=1; ?>
                @foreach($warrior_diligent as $key2=>$value2)
                <li>  <b>{{$j}}</b>  {{ $value2->name }} </li><hr>
                <?php $j=$j+1; ?>

                @endforeach
              </ul>
            </div>
        </div>
      </div>

  </div>


@else
  <center>
    <h2>還沒有人答題喔快去答題看看</h2>
  </center>
@endif

  </div>

@endsection
