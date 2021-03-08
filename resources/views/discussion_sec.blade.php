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
   color: #fff;
   font-size: 12pt;
   box-shadow: 7px 7px 5px #e6e6e6;
 }
 .list-bk{
   margin-top: 90px;
 }
 .list-group-item{
   border-radius: 0px !important;
 }
</style>

@endsection
@section('content')
<div class="container-body">
  <br>
  <div class="row">
    <div class="col-sm-2"><div class="dis_title">{{$id}}</div>
      <br>
     <a href="{{url('discussion')}}"><div class="back_btn">回上一頁</div></a>
      <br>
      <a href="{{url('discussion_ask/'.$id)}}"><div class="back_btn">我要發問</div></a>
    </div>

    <div class="col-sm-8">
        <div class="list-bk">
          <ul class="list-group">

              @foreach ($ask as $asks)
                @if($asks->chapter_id == $chapter->id)
                  <a href="{{url('/discussion_broad/'.$asks->id)}}">
                    <li class="list-group-item">
                      {{$asks->title}}
                    </li>
                  </a>
                @endif
              @endforeach

          </ul>
      </div>
      <!-- <center><ul class="pagination">
        <li ><a href="#"style="background-color:#669999;color:#fff">1</a></li>
        <li><a href="#" style="background-color:#669999;color:#fff">2</a></li>
        <li><a href="#" style="background-color:#669999;color:#fff">3</a></li>
        <li><a href="#" style="background-color:#669999;color:#fff">4</a></li>
        <li><a href="#" style="background-color:#669999;color:#fff">5</a></li>
      </ul></center> -->
    </div>
    <div class="col-sm-2"></div>
  </div>
</div>

@endsection
