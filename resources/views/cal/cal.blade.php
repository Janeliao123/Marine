@extends('layout.layout')
@section('css')
<style media="screen">
 body{
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
  background-color: #649cca;
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
<div class="row">
  <div class="col-lg-4 col-md-6">
    <div class="row" style="margin-top:0px">
      <div class="card1 top_counter">
        <div class="header-blue">
          <center><h3 style="color:#fff"><b>答對率</b></h3></center>
        </div>
        <div class="body1">
          <center><h1>{{ $avg }}%</h1></center>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="card1 top_counter">
          <div class="body1">
            <canvas id="pieChart2"></canvas>
          </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4 col-md-6">
    <div class="card1 top_counter">
      <div class="header-pink">
        <center><h3 style="color:#fff"><b>H&nbsp;O&nbsp;T&nbsp;!</b></h3></center>
      </div>
        <div class="body1">
          <ul style="list-style-type: none;">
            @if(isset($hot))
            <?php $j=1 ?>
                @foreach ($hot as $value)
                  <li>
                    <a href="{{ url('compiler') }}?qid={{$value->id}}" target="_blank" >
                      @if($j < 4) <span style="color:#e16c6c;font-size:20px">@else <span> @endif <b>{{ $j }} </b></span>&nbsp;&nbsp;{{ $value->title }}
                      <span class="label label-default"  style="float:right">{{ $value->count }}</span><span style="float:right">&nbsp;&nbsp;&nbsp;</span><span class="label" style="float:right">
                        @if($value->difficulty ==1 )
                        <span class="w3-tag w3-small w3-yellow">
                          易
                        </span>
                        @elseif($value->difficulty ==2)
                        <span class="w3-tag w3-small w3-blue">
                          中
                        </span>
                        @else
                        <span class="w3-tag w3-small w3-red">
                          難
                        </span>
                        @endif
                      </span>
                    </a>
                  </li><hr>
                  <?php $j=$j+1 ?>
                @endforeach
            @else
              <h4>尚未有資料</h4>
            @endif
          </ul>
        </div>
    </div>
  </div>

  <div class="col-lg-4 col-md-6">
    <div class="card1 top_counter">
      <div class="header-green">
        <center><h3 style="color:#fff"><b>C&nbsp;H&nbsp;A&nbsp;LL&nbsp;ENGE!</b></h3></center>
      </div>
        <div class="body1">
          <ul style="list-style-type: none;">
            @if(isset($hard))
            <?php $i=1 ?>
                @foreach ($hard as $hard_value)
                  <li>
                    <a href="{{ url('compiler') }}?qid={{$hard_value->id}}" target="_blank" ><?php $rate=round($hard_value->correct_rate*100,0); ?>
                      @if($i < 4) <span style="color:#4dbca1;font-size:20px">@else <span> @endif <b>{{ $i }} </b></span>&nbsp;&nbsp;{{ $hard_value->title }}
                      <span class="label label-default" style="float:right">{{ $rate }}%</span><span style="float:right">&nbsp;&nbsp;&nbsp;</span>
                      <span class="label" style="float:right">
                        @if($hard_value->difficulty ==1 )
                        <span class="w3-tag w3-small w3-yellow">
                          易
                        </span>
                        @elseif($hard_value->difficulty ==2)
                        <span class="w3-tag w3-small w3-blue">
                          中
                        </span>
                        @else
                        <span class="w3-tag w3-small w3-red">
                          難
                        </span>
                        @endif
                      </span>
                    </a>
                  </li><hr>
                  <?php $i=$i+1 ?>
                @endforeach

            @else
              <h4>尚未有資料</h4>
            @endif
          </ul>
        </div>
    </div>
  </div>

</div>
@endsection
@section('js')
<script src="/js/chart.js"></script>
<script type="text/javascript">
//pie
var ctxP = document.getElementById("pieChart2").getContext('2d');
var myPieChart = new Chart(ctxP, {
    type: 'pie',
    data: {
        labels: ["難", "中", "易"],
        datasets: [
            {
                data: [{{$count_h}}, {{$count_m}}, {{$count_e}}],
                backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C"],
                hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870"]
            }
        ]
    },
    options: {
        responsive: true
    }
});

</script>

@endsection
