@extends('layout.layout')
@section('css')
<style media="screen">

#banner {
  background-image: url('dis.png') !important;
}

 .list-group-item-top{
   background-color:#435761;
 }
 .category-logo{

    height: 150px;
    float: left;
    margin: 15px;
    /* margin-right: 15px; */
 }
 .category-name{
    display: inline-block;
    max-width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    vertical-align: text-top;
    line-height: 1.2;
    border-bottom:solid 2px gray;
 }
 .category-element{
   border-left:solid 6px #9EB83B;
 }
 .dis_title{
   background-color:#9EB83B;
   width: 150px;
   height: 150px;
   padding: 40px;
   text-align: center;
   color: #fff;
   font-size: 40pt;
   box-shadow: 7px 7px 5px #e6e6e6;
 }
 .back_btn{
   background-color:#cccccc;
   width: 150px;
   height: 40px;
   padding: 10px;
   text-align: center;
   color: #000000;
   font-size: 12pt;
   box-shadow: 7px 7px 5px #e6e6e6;
 }


/* Add a card effect for articles */
.card {
     background-color: white;
     padding: 20px;
     margin-top: 20px;
     border-radius: 20px;
     font-size: 24px;
}

/* Clear floats after the columns */
.row:after {
    content: "";
    display: table;
    clear: both;
}

</style>

@endsection
@section('content')
<div class="container-body">
  <br>
  <div class="row">
    <div class="col-sm-2"><div class="dis_title">1</div><br><a href="{{url('discussion')}}"><div class="back_btn">回討論區</div></a></div>
    <div class="col-sm-8">
    <div class="row">
      <h1> CH{{$ask->chapter_id}} >> {{$ask->title}}</h1>
    <div class="card">
      <div>
        <div class="col-sm-1">
          <img src="/img/profile2.jpg" alt="userpic" width="80" height="80"  style="border-radius: 40px">
        </div>
        <div class="col-sm-11">
          <h4>{{$user->name}}</h4>
          <h5>發布時間 :{{$ask->created_at}}</h5> 
        </div>
      </div>
      <br><br><br><br>
      <h4>{!!$ask->content!!}</h4>

    </div>
    @foreach($answer_name as $answer_name)
      @foreach($answer as $answers)
        @if($answers->discussion_ask_id == $ask->id && $answer_name->id == $answers->user_id)
          <div class="card">
            <div>
              <div class="col-sm-1">
                <img src="/img/profile2.jpg" alt="userpic" width="80" height="80"  style="border-radius: 40px">
              </div>

              <div class="col-sm-11">
                <h4>{{$answer_name->name}}</h4>

                <h5>發布時間 :{{$answers->created_at}}</h5> 
              </div>
            </div>
            <br><br><br><br>
            <h4>{!!$answers->answer!!}</h4>

         </div>
         @endif
      @endforeach
    @endforeach


    <br>
    <a href="{{url('discussion_answer/'.$ask->id)}}" ><div class="back_btn" style="align-items: center; ">我要回答</div></a>

    <br>  
      <center><ul class="pagination">
        <li ><a href="#"style="background-color:#669999;color:#fff">1</a></li>
        <li><a href="#" style="background-color:#669999;color:#fff">2</a></li>
        <li><a href="#" style="background-color:#669999;color:#fff">3</a></li>
        <li><a href="#" style="background-color:#669999;color:#fff">4</a></li>
        <li><a href="#" style="background-color:#669999;color:#fff">5</a></li>
      </ul></center>
    </div>
    <div class="col-sm-2"></div>
  </div>
</div>

@endsection
