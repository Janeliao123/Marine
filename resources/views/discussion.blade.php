@extends('layout.layout')
@section('css')
<style media="screen">
#banner {
	background-image: url('img/dis.png') !important;
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
</style>

@endsection
@section('content')

<div id="banner"></div>
<div class="container-body">
<br>
<div class="row">
  <div class="col-sm-1">

  </div>
  <div class="col-sm-9">
    <center>
      <table style="width:100%">
        <thead>
          <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($chapter as $chapter)

          <tr style="border-bottom:solid 1px gray;border-top:solid 1px gray">
            <td class="category-element">
              <a href="{{url('discussion_sec/'.$chapter->id)}}">
                <img src="/img/chapter_number/{{$chapter->id}}.png" height="150px;">
                <!-- <img class="category-logo" src="https://image.flaticon.com/icons/svg/91/91639.svg" > -->
              </a>
            </td>
            <td style="padding:15px">
              <a href="{{url('discussion_sec/'.$chapter->id)}}" class="category-name" style="font-size: 30px">{{$chapter->title}}</a>
            </td>
            <td>
              <span style="background-color:#66BAB7;color:#fff;padding:5px;font-size:12px">發問人數:{{$count[$chapter->id]}}</span>
            </td>
            <td style="padding:15px">
            <h5><span style="font-weight:bold;">[Solved]</span>2018-09-21請問這題這樣寫對嗎?</h5>
              <h5><span style="font-weight:bold;">[Unsolved]</span>2018-09-21請問這題這樣寫對嗎?</h5>
            </td>
          </tr>
          @endforeach

        </tbody>
      </table>
    </center>

  </div>
  <div class="col-sm-2">

  </div>


</div>

@endsection
