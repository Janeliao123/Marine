@extends('layout.layout')

@section('content')
  <!-- banner -->
<div id="banner"></div>
<div class="container-body">

<div class="row">
    <div class="col-sm-2 row-left" >
      <h6>&nbsp;</h6>
      <!-- <ul class="list-group w3-card" style="paddig:2%;color:#fff">
        <li class="list-group-item list-group-item-top" ><center><i class="fa fa-hand-o-right"style="font-size:24px"></i>&nbsp;繼續挑戰</center></li>
      </ul>
      <ul class="list-group w3-card" style="paddig:2%;color:#fff">
        <li class="list-group-item list-group-item-top" ><center><i class="fa fa-grav"style="font-size:24px"></i>&nbsp;學習進度表</center></li>
      </ul> -->
      <div class="panel-group w3-card">
        <div class="panel">
          @foreach($chapter as $chapter)
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#{{ $chapter->id }}"><h5>{{ $chapter->title }}</h5></a>
                </h4>
              </div>
              <div id="{{ $chapter->id }}" class="panel-collapse collapse in">
                @foreach($section as $sections)
                  @if($sections->chapter_id == $chapter->id)
                    <div class="panel-body"><a href="{{ url('/section/'.$sections->title.'/'.$sections->chapter_id.'/'.$sections->id) }}"><h6>{{ $sections->title }}</h6></a></div>
                  @endif
                @endforeach
              </div>
            @endforeach
        </div>
      </div>
    </div>

    <div class="col-sm-9" >
      <div class="tab_container">
      			<input id="tab1" type="radio" name="tabs" checked>
      			<label for="tab1"><i class="fa fa-code"></i><span>系統公告</span></label>
            @if(Auth::check())
              <input id="tab2" type="radio" name="tabs">
              <label for="tab2"><i class="fa fa-pencil-square-o"></i><span>班級公告</span></label>
            @endif
            @if(!Auth::guard('admin')->guest())
              <input id="tab2" type="radio" name="tabs">
              <label for="tab2"><i class="fa fa-pencil-square-o"></i><span>班級公告</span></label>
            @endif


      			<section id="content1" class="tab-content">
              @foreach ($allnews as $allnew)

                  <p>{{ $allnew->created_at}}
                  <a data-toggle="modal" data-target="#a{{ $allnew->id }}">
                    &nbsp;{{ $allnew->title}}
                  </a></p><hr>

                    <div class="modal fade" id="a{{ $allnew->id }}" role="dialog">
                        <div class="modal-dialog">
                          <!-- Modal content-->
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                     <h4 class="modal-title">{{ $allnew->title }}</h4>
                               </div>
                              <div class="modal-body">
                                <p>{!!$allnew->content!!}</p>
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
                          </div>

                          </div>
                      </div>
              @endforeach
      			</section>
            <!-- 學生登入看到的-->
            @if(Auth::check())
      			<section id="content2" class="tab-content">
              @foreach ($class_news as $class_news)
                <p>{{ $class_news->created_at}}
                <a data-toggle="modal" data-target="#c{{ $class_news->id }}">
                    &nbsp; {{ $class_news->title}}
                </a></p><hr>

                  <div class="modal fade" id="c{{ $class_news->id }}" role="dialog">
                   <div class="modal-dialog">

                     <!-- Modal content-->
                     <div class="modal-content">
                       <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal">&times;</button>
                         <h4 class="modal-title">{{ $class_news->title }}</h4>
                       </div>
                       <div class="modal-body">
                         <p>{!!$class_news->content!!}</p>
                       </div>
                       <div class="modal-footer">
                         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                       </div>
                     </div>

                   </div>
                 </div>
              @endforeach
      			</section>
            @endif
            <!-- 教師登入看到的-->
            @if(!Auth::guard('admin')->guest())
      			<section id="content2" class="tab-content">
              @foreach ($class_news as $class_news)
                <p>{{ $class_news->created_at}}
                <a data-toggle="modal" data-target="#c{{ $class_news->id }}">
                    &nbsp; {{ $class_news->title}}
                </a></p><hr>

                  <div class="modal fade" id="c{{ $class_news->id }}" role="dialog">
                   <div class="modal-dialog">

                     <!-- Modal content-->
                     <div class="modal-content">
                       <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal">&times;</button>
                         <h4 class="modal-title">{{ $class_news->title }}</h4>
                       </div>
                       <div class="modal-body">
                         <p>{!!$class_news->content!!}</p>
                       </div>
                       <div class="modal-footer">
                         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                       </div>
                     </div>

                   </div>
                 </div>
              @endforeach
      			</section>
            @endif
      		</div>


      </div>
    </div>
  </div>
</div>
@endsection
@section('css')
<style media="screen">
 .list-group-item-top{
   background-color:#3e87b9;
 }
 *,
 *:after,
 *:before {
 	-webkit-box-sizing: border-box;
 	-moz-box-sizing: border-box;
 	box-sizing: border-box;
 }

 .clearfix:before,
 .clearfix:after {
 	content: " ";
 	display: table;
 }

 .clearfix:after {
 	clear: both;
 }


 /*Fun begins*/
 .tab_container {
 	width: 90%;
 	margin: 0 auto;
 	padding-top: 70px;
 	position: relative;
 }

 input, section {
   clear: both;
   padding-top: 10px;
   display: none;
 }

 label {
   font-weight: 700;
   font-size: 18px;
   display: block;
   float: left;
   width: 20%;
   padding: 1.5em;
   color: #757575;
   cursor: pointer;
   text-decoration: none;
   text-align: center;
   background: #f0f0f0;
 }

 #tab1:checked ~ #content1,
 #tab2:checked ~ #content2,
 #tab3:checked ~ #content3,
 #tab4:checked ~ #content4,
 #tab5:checked ~ #content5 {
   display: block;
   padding: 20px;
   background: #fff;
   color: #999;
   border-bottom: 2px solid #f0f0f0;
 }

 .tab_container .tab-content p,
 .tab_container .tab-content h3 {
   -webkit-animation: fadeInScale 0.7s ease-in-out;
   -moz-animation: fadeInScale 0.7s ease-in-out;
   animation: fadeInScale 0.7s ease-in-out;
 }
 .tab_container .tab-content h3  {
   text-align: center;
 }

 .tab_container [id^="tab"]:checked + label {
   background: #fff;
   box-shadow: inset 0 3px #0CE;
 }

 .tab_container [id^="tab"]:checked + label .fa {
   color: #0CE;
 }

 label .fa {
   font-size: 1.3em;
   margin: 0 0.4em 0 0;
 }

 /*Media query*/
 @media only screen and (max-width: 930px) {
   label span {
     font-size: 14px;
   }
   label .fa {
     font-size: 14px;
   }
 }

 @media only screen and (max-width: 768px) {
   label span {
     display: none;
   }

   label .fa {
     font-size: 16px;
   }

   .tab_container {
     width: 98%;
   }
 }

 /*Content Animation*/
 @keyframes fadeInScale {
   0% {
   	transform: scale(0.9);
   	opacity: 0;
   }

   100% {
   	transform: scale(1);
   	opacity: 1;
   }
 }
</style>

@endsection
@section('js')
<script type="text/javascript">
  $(document).ready(function(){
      $("#btnn").click(function(){
          window.location = "admin/newsedit";
      });
  });
</script>

@endsection
