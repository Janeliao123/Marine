@extends('layout.layout')
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
</style>
@endsection
@section('content')
<div class="container-body">
  <div class="row">
      <div class="col-sm-2 " >
        <div class="panel-group w3-card">
          <div class="panel">
            @foreach($chapterAll as $chapterAll)
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" href="#{{ $chapterAll->id }}"><h5>{{ $chapterAll->title }}</h5></a>
                  </h4>
                </div>
                <div id="{{ $chapterAll->id }}" class="panel-collapse collapse in">
                  @foreach($sectionAll as $sectionAlls)
                    @if($sectionAlls->chapter_id == $chapterAll->id)
                      <div class="panel-body"><a href="{{ url('/section/'.$sectionAlls->title.'/'.$sectionAlls->chapter_id.'/'.$sectionAlls->id) }}"><h6>{{ $sectionAlls->title }}</h6></a></div>
                    @endif
                  @endforeach
                </div>
              @endforeach
          </div>
        </div>
      </div>
      <div class="col-sm-8 ">
        <div class="panel-group w3-card">
          <div class="panel">
                <div class="panel-header-wh">
                  <h3 class="panel-title">
                    <h3 style="font-weight: bold;border-left:solid 4px #92b5cf;border-right:solid 4px #92b5cf;">&nbsp;{{$chapter->title}}>{{$section->title}}</h3>
                  </h3>
                </div>
                <div class="panel-collapse collapse in">
                  <div class="panel-body">
                    @foreach($question as $key=>$question)
                    <div class="row" >
                        <div class="col-sm-8">
                            <a href="{{ url('compiler') }}?qid={{$question->id}}" target="_blank">
                              <h4>{{$key+1}}、{{$question->title}}</h4>
                            </a>
                          </div>

                        <div class="col-sm-4">
                          <p>答題人數:{{$question->count}}&nbsp;&nbsp;
                            答對率:{{ number_format($question->correct_rate*100,2) }}%&nbsp;&nbsp;

                              @if($question->difficulty ==1 )
                              <span class="w3-tag w3-small w3-yellow">
                                易
                              </span>
                              @elseif($question->difficulty ==2)
                              <span class="w3-tag w3-small w3-blue">
                                中
                              </span>
                              @else
                              <span class="w3-tag w3-small w3-red">
                                難
                              </span>
                              @endif
                          </p>
                        </div>
                    </div><hr>
                    @endforeach

                  </div>
              </div>

          </div>
        </div>
      </div>
  </div>

</div>

@endsection
