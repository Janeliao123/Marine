@extends('layout.layout')
@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<style media="screen">
#banner {
	position: relative;
	margin: 0;
	padding: 0;
	width: 100%;

  top:-10px;
	height: 280px;
	background-image: url('https://scontent.ftpe8-1.fna.fbcdn.net/v/t1.0-9/30443505_1205665472870507_7631192548869931008_o.jpg?_nc_cat=0&oh=3f0ddb5bad2527490c0f98f35719039d&oe=5B71E6D2');
	background-repeat: no-repeat;
	background-position: center;
	background-size: cover;
}

 p.victor {
    color: grey ;
    font-size:18px;

}
 .brand-logo{
   border-left:2px solid #000;
   border-bottom:2px solid #000;
   margin-left: 5%;
 }
 h3, h4 {
      margin: 10px 0 30px 0;
      letter-spacing: 10px;
      color: #111;
  }
  .container-list {
      padding: 80px 120px;
  }
  .list-group-item{
    font-size: 16px;
  }
  .list-group-item:first-child {
      border-top-right-radius: 0;
      border-top-left-radius: 0;
  }
  .list-group-item:last-child {
      border-bottom-right-radius: 0;
      border-bottom-left-radius: 0;
  }

  .w3-card,.w3-card-2{box-shadow:0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)}
  .w3-card-4,.w3-hover-shadow:hover{box-shadow:0 4px 10px 0 rgba(0,0,0,0.2),0 4px 20px 0 rgba(0,0,0,0.19)}
  .panel-heading{
    background-color:#435761 !important;
    color:#fff;
  }
  .row-left{
    padding-top: 2%;

  }
  .list-group-item-top{
    background-color:#435761;
  }
  .container-body{
    margin-left: 5%;
  }


  /* Create three equal columns that floats next to each other */
 .column {
     /* float: left;
     width: 30%; */
     height: 40%;
     background-color:#f8f8f8;
     box-sizing: border-box;
     padding-top: 1% ;
     padding-bottom: 1% ;
 }


 /* Clear floats after the columns */
 .row:after {
     content: "";
     display: table;
     clear: both;
 }

 /* Responsive layout - makes the three columns stack on top of each other instead of next to each other */
 @media screen and (max-width:600px) {
     .column {
         width: 100%;
     }
 }

 .block {
    display: block;
    width: 100%;
    height: 100%;
    border: none;
    background-color: white;
    color: gray;
    padding: 14px 28px;
    font-size: 16px;
    cursor: pointer;
    text-align: center;
}

.block:hover {
    background-color: rgb(194, 198, 198);
    color: black;
}

.map{
  padding:0px;
  margin:0px;
  border:0;
  display:inline;
}

</style>

@endsection
@section('content')
<div class="row" >
  <div class="column col-sm-12" style="background-color: rgb(211, 238, 242); padding: 50px">
    <center>
      <div class="column col-sm-6" style="background-color: rgb(211, 238, 242);">

        @if($stu_level > 45)

        <img src="/img/level/6.PNG" style="border-radius:50%;  width:20% ; height:70%;">
        @elseif($stu_level > 30)
        <img src="/img/level/5.PNG" style="border-radius:50%;  width:20% ; height:70%;">
        @elseif($stu_level > 20)
        <img src="/img/level/4.PNG" style="border-radius:50%;  width:20% ; height:70%;">
        @elseif($stu_level > 10)
        <img src="/img/level/3.PNG" style="border-radius:50%;  width:20% ; height:70%;">
        @elseif($stu_level > 5)
        <img src="/img/level/2.PNG" style="border-radius:50%;  width:20% ; height:70%;">
        @else
        <img src="/img/level/1.PNG" style="border-radius:50%;  width:20% ; height:70%;">
        @endif
        <br><br>
        <i class="fa fa-address-book" style="font-size:25px"></i>
        <font size="4" style="color:grey"> 稱號:{{ Auth::user()->name }}</font>
        <br>

      </div>
      <div class="column col-sm-6" style="background-color:rgb(211, 238, 242); padding-right: 70px; padding-left: 70px;p">
       <center>
        <p class=victor>
          經驗值
        </p>
				@if($stu_level > 45)
				<div class="progress" style="height: 20px;">
					<div class="progress-bar progress-bar-success progress-bar-striped active"
					 role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%;">
						<font size="4">--你已無人能比，太優秀了--</font>
					</div>
				</div>
				@elseif($stu_level > 30)
				<?php $i = round($stu_level/46*100,0);$j=46-$stu_level; ?>
				<code>還差{{$j}}題就可以晉級囉</code><br><br>
				<div class="progress" style="height: 20px;">
					<div class="progress-bar progress-bar-success progress-bar-striped active"
					 role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:{{$i}}%;">
						<font size="4">{{$i}}%</font>
					</div>
				</div>
				@elseif($stu_level > 20)
				<?php $i = round($stu_level/31*100,0);$j=31-$stu_level; ?>
				<code>還差{{$j}}題就可以晉級囉</code><br><br>
				<div class="progress" style="height: 20px;">
					<div class="progress-bar progress-bar-success progress-bar-striped active"
					 role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:{{$i}}%;">
						<font size="4">{{$i}}%</font>
					</div>
				</div>
				@elseif($stu_level > 10)
				<?php $i = round($stu_level/21*100,0);$j=21-$stu_level; ?>
				<code>還差{{$j}}題就可以晉級囉</code><br><br>
				<div class="progress" style="height: 20px;">
					<div class="progress-bar progress-bar-success progress-bar-striped active"
					 role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:{{$i}}%;">
						<font size="4">{{$i}}%</font>
					</div>
				</div>
				@elseif($stu_level > 5)
				<?php $i = round($stu_level/11*100,0);$j=11-$stu_level; ?>
				<code>還差{{$j}}題就可以晉級囉</code><br><br>
				<div class="progress" style="height: 20px;">
					<div class="progress-bar progress-bar-success progress-bar-striped active"
					 role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:{{$i}}%;">
						<font size="4">{{$i}}%</font>
					</div>
				</div>
				@else
				<?php $i = round($stu_level/6*100,0);$j=6-$stu_level; ?>
				<code>還差{{$j}}題就可以晉級囉</code><br><br>
				<div class="progress" style="height: 20px;">
					<div class="progress-bar progress-bar-success progress-bar-striped active"
					 role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:{{$i}}%;">
						<font size="4">{{$i}}%</font>
					</div>
				</div>
				@endif


        <br><br><br>
        <!-- <p class=victor>
        累積在線時間
        <br>
        <span class="glyphicon glyphicon-time"></span>
        20:35:42
        </p> -->
        </center>
      </div>
    </center>
  </div>
</div>


<div class="column col-sm-12" style="height:20%; padding: 20px;" >
  <div class="col-sm-4" >
    <a href="{{url('personal_discussion')}}">
      <button type="button" class="block" style="font-size:20; height:80px;"><i class="far fa-star fa-spin fa-fw"></i> 珍藏題目</button>
    </a>
  </div>
  <div class="col-sm-4" >
    <a href="{{url('personal_discussion')}}">
      <button type="button" class="block" style="font-size:20; height:80px;">我的提交</button>
    </a>
  </div>
  <div class="col-sm-4" >
    <a href="{{url('personal_discussion')}}">
      <button type="button" class="block" style="font-size:20; height:80px;">問題管理</button>
    </a>
  </div>

</div>

<div class="col-sm-12" style="background-color:rgb(211, 238, 242); padding: 50px; font-size: 20px;">
  <center><p class=victor>
      課程地圖<br>

      <br>
      <br>
      <br>
      <div class="map_web">
        @foreach($chapter as $chapters)

          <div style="width:99%" >
            <?php $i=0; $j=0; ?>
            @foreach($section as $sections)
              @if($sections->chapter_id == $chapters->id && $sections->chapter_id % 2 == 1)
                @foreach($section as $se_1)
                  @if($se_1->chapter_id == $chapters->id && $i == 0)
										<img src="/img/map/{{ $pic_name[$se_1->id] }}" border="0" alt='' style="margin-right:-5px;">
                  @endif
                @endforeach
                <?php $i=1; ?>
              @endif
              @if($sections->chapter_id == $chapters->id && $sections->chapter_id % 2 == 0)
                @foreach($section->reverse()->all() as $se_2)
                  @if($se_2->chapter_id == $chapters->id && $j == 0)
                    <img src="/img/map/{{ $pic_name[$se_2->id] }}" border="0" alt='' style="margin-right:-5px;">
								  @endif
                @endforeach
                <?php $j=1; ?>
              @endif
            @endforeach
          </div>
        @endforeach


      </div>
			<div class="map_phone">
        @foreach($chapter as $chapters)

          <div style="width:99%" >
            <?php $i=0; $j=0; ?>
            @foreach($section as $sections)
              @if($sections->chapter_id == $chapters->id && $sections->chapter_id % 2 == 1)
                @foreach($section as $se_1)
                  @if($se_1->chapter_id == $chapters->id && $i == 0)
										<img src="/img/map_phonea/{{ $pic_name[$se_1->id] }}" border="0" alt='' style="margin-right:-6px;margin-top:-2px">
                  @endif
                @endforeach
                <?php $i=1; ?>
              @endif
              @if($sections->chapter_id == $chapters->id && $sections->chapter_id % 2 == 0)
                @foreach($section->reverse()->all() as $se_2)
                  @if($se_2->chapter_id == $chapters->id && $j == 0)
                    <img src="/img/map_phonea/{{ $pic_name[$se_2->id] }}" border="0" alt='' style="margin-right:-6px;margin-top:-2px">
								  @endif
                @endforeach
                <?php $j=1; ?>
              @endif
            @endforeach
          </div>
        @endforeach


      </div>

  </p></center>
</div>





@endsection
@section('js')
<script type="text/javascript">
function myFunction(x) {
    if (x.matches) {
			// 手機板
			$('.map_web').css('display','none');
			$('.map_phone').css('display','block');
    } else {

			// 電腦版
			$('.map_phone').css('display','none');
			$('.map_web').css('display','block');
    }
}

	var x = window.matchMedia("(max-width: 700px)")
	myFunction(x)
	x.addListener(myFunction)
</script>
@endsection
