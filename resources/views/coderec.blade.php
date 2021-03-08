@extends('layout.layout')

@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<style>
.panel-heading {
    background-color: #8FBC8F;
    color: #fff;
}
.tab-content{
    padding-left: 30px;
}
.alert {
  /* display:inline-block; */
}
.btnoutline{
  border: 1.5px solid black;
  background-color: white;
  padding: 5px 10px;
  cursor: pointer;
  border-radius: 5px;
}
.btnoutline {
    border-color: #e7e7e7;
    color: black;
}

.btnoutline:hover {
    background: #e7e7e7;
}

</style>
@stop

@section('content')
<div class="container">

  <br><br>
  <div class="panel-heading"><h4 style="text-align:center;"><i class="fas fa-school"></i>&nbsp;&nbsp;<strong>作 業 紀 錄</strong></h4></div>
  <div class="panel panel-default" >
    <div class="panel-body">
    @if(isset($handin_hw))
    <div class="alert alert-success">
    <strong>已提交!</strong> 可以刪除或是重新選擇!
    <form action="{{ url('userhw/delHw') }}/{{$handin_hw->id}}" method="post">
        @csrf

        <button type="submit" class="btn btn-default  btn-md btnoutline">刪除</button>
    </form>

    </div>
    @else
    <div class="alert alert-danger">
    <strong>未提交!</strong> 請提交其中一筆程式!
    </div>
    @endif
    <a href="{{ url('userhw') }}"><button type="button" class="btn btn-default  btn-md btnoutline"><i class="fas fa-reply"></i>&nbsp;返回</button></a><br>

        @if(!empty($code[$id]))
        @for($i=0;$i<count($code[$id]);$i++)
            @if($status[$id][$i]=='AC')
            <br>
            <div class="alert alert-success"><code>{!!$code[$id][$i]!!}</code>

            <hr>
                <div class="row">
                    <div class="col col-sm-10 col-md-10">
                        <p>提交狀態:&nbsp;<span class="label label-success">{{$status[$id][$i]}}</span></p><p>提交時間:&nbsp;{{$time[$id][$i]}}</p>
                    </div>
                    <div class="col col-sm-2 col-md-10">
                        <a href="{{url("/userhw/handin/")}}/{{$cid}}/{{$id}}/{{$codei[$id][$i]}}">
                            <button type="button" class="btn btn-default  btn-md btnoutline">提交</button>
                        </a>
                    </div>
                </div>
            </div>

            @else
            <br>
            <div class="alert alert-danger"><code>{!!$code[$id][$i]!!}</code>
            <hr>
            <div class="row">
                    <div class="col col-sm-10 col-md-10">
                        <p>提交狀態:&nbsp;<span class="label label-danger">{{$status[$id][$i]}}</span></p><p>提交時間:&nbsp;{{$time[$id][$i]}}</p>
                    </div>
                    <div class="col col-sm-2 col-md-10">
                      @if(is_null($due_date) || date("Y-m-d H:i:s")<$due_date)
                        <a href="{{url("/userhw/handin/")}}/{{$cid}}/{{$id}}/{{$codei[$id][$i]}}">
                            <button type="button" class="btn btn-default  btn-md btnoutline">提交</button>
                        </a>
                      @else
                          <button type="button" class="btn btn-danger  btn-md disabled">提交時間已截止!</button>
                      @endif
                    </div>
                </div>
            </div>

            @endif

        @endfor

        @else
        <h3 style="text-align:center;"><span class="label label-danger">尚未寫過此題!</h3>
        @endif

      </div>
    </div>
</div>


@endsection
