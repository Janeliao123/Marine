@extends('layout.admin_layout')

@section('css')
<style media="screen">
#excel_section2,#single_section2{
  display: none;
}
.form-control{
  background-color:#fbf8f2;
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
    border-radius: .55rem;
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

</style>
@endsection

@section('content')

@if($is_set == 0 )
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-warn">
            <div class="panel-heading">@if($is_set == 0 )  @else{{ $last_year }} 學年度修課名單 @endif</div>
            <div class="panel-body">
                @if($is_set == 0 )
                  <p>{{ $user_lists }}</p>
                @endif
            </div>
        </div>
      </div>
    </div>
@else
@if (session('alert'))
    <div class="alert alert-danger">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ session('alert') }}
    </div>
@endif
@if (session('success'))
    <div class="alert alert-success">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ session('success') }}{{ session('name') }}
    </div>
@endif
<center><h3><span class="glyphicon glyphicon-file"></span>&nbsp;最近一次修課名單</h3><hr></center>
@if($c_users == 0)
  <div class="row">
    <div class="col-lg-5 col-md-6">
      <div class="card1 top_counter">
          <div class="body1">
            <b>尚未新增學生資料!</b>
          </div>
      </div>
    </div>
  </div>
@else
<div class="row">
  <div class="col-md-6 ">
    <div class="panel panel-warn">
        <div class="panel-heading">{{ $year }} 學年度修課名單 </div>
        <div class="panel-body">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>學號</th>
                <th>姓名</th>
                <th>是否註冊</th>

              </tr>

            </thead>
            <tbody>
              @foreach($users as $useres)
                <tr>
                  <td>{{ $useres->acct }}</td>
                  <td>{{ $useres->name }}</td>
                  <td>@if( $is_register[$useres->id]==0 ) <span class="glyphicon glyphicon-remove-circle" style="color:#ff1a1a;font-size:20px"></span> @else <span class="glyphicon glyphicon-ok-circle" style="color:#00cc99;font-size:20px"></span> @endif</td>

                </tr>
              @endforeach

            </tbody>
          </table>

        </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="panel panel-warn">
        <div class="panel-heading">同學答題總狀況 </div>
        <div class="panel-body">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>學號</th>
                <th>姓名</th>
                <th>答題數</th>
                <th>答對率</th>
                <th></th>
              </tr>

            </thead>
            <tbody>
              @foreach($users as $userss)
                <tr>
                  <td>{{ $userss->acct }}</td>
                  <td>{{ $userss->name }}</td>
                  <td>@if( $is_register[$userss->id]==0 ) <span class="glyphicon glyphicon-remove-circle" style="color:#ff1a1a;font-size:20px"></span>&nbsp; @else {{ $stu_q[$userss->id] }} @endif</td>
                  <td>@if( $is_register[$userss->id]==0 ) <span class="glyphicon glyphicon-remove-circle" style="color:#ff1a1a;font-size:20px"></span>&nbsp; @else {{ $stu_c_avg[$userss->id] }} @endif</td>
                  <td></td>
                </tr>
              @endforeach

            </tbody>
          </table>

        </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-3 col-md-6">
      <div class="card1 top_counter">
          <div class="body1">
            <div class="icon"><center><h5 class="number">{{ $avg_q }}</h5></center></div>
                <div class="content">
                    <div class="text"><b>平均答題數</b></div>
                </div><hr>
                <div class="icon"><center><h5 class="number">{{ $avg_c_q }}</h5></center> </div>
                <div class="content">
                    <div class="text"><b>平均答對率</b></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6">
      <div class="card1 top_counter">
          <div class="body1">
            <canvas id="pieChart"></canvas>
          </div>
      </div>
    </div>

</div>


@endif

<div id="delModal" class="modal fade" role="dialog">
  <div class="modal-dialog" >

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <center>
          <a href="{{ url('admin/user_lists/deleteAllUser/1/'.$course_id) }}">
            <button type="button" class="btn btn-danger" >確認刪除</button>
          </a>
        </center>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">*新增修課名單</h4>
        </div>
        <div class="modal-body">
          <div class="btn-group">
            <a class="btn dropdown-toggle btn-select" data-toggle="dropdown" href="#">請選擇新增名單方式<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li id="esection2"><a href="#">excel上傳</a></li>
              <li id="ssection2"><a href="#">單一輸入</a></li>
            </ul>
          </div>
          <div id="excel_section2">
            <form class="form-horizontal" method="POST" action="{{ route('import_process') }}" enctype="multipart/form-data">
              {{ csrf_field() }}
              <br><br><code>!!注意 請按照格式上傳&nbsp;<a href="/exports/example.xlsx"><b><span class="glyphicon glyphicon-download"></span>點我下載範例檔案</b></a></code>
              <br><br>
              <input type="hidden" name="course_list_id" value="{{ $course_id }}">
              <input type="hidden" name="type" value="1">
              <button type="button" class="btn btn-success btn-sm" >
                <input id="csv_file" type="file" class="form-control" name="file" required>
              </button>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-warning btn-sm"></span>確認上傳</span></button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </form>
          </div>
          <div id="single_section2">
            <br><br>
            <form class="form-horizontal" method="POST" action="{{ route('import_process') }}" enctype="multipart/form-data">
              {{ csrf_field() }}
               <input type="hidden" name="course_list_id" value="{{ $course_id }}">
              <input type="hidden" name="type" value="2">
              <div class="form-group">
                <code>*</code><label >學號:</label>
                <input type="text" class="form-control" name="acct" required>
              </div>
              <div class="form-group">
                <code>*</code><label >姓名:</label>
                <input type="text" class="form-control" name="name" required>
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-warning btn-sm"></span>確認上傳</span></button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

@endif

@endsection

@if($is_set == 0 )

@else
@section('js')
<script src="/js/chart.js"></script>
<script type="text/javascript">
<script src="/js/chart.js"></script>
<script type="text/javascript">
$(".dropdown-menu li a").click(function(){
  var selText = $(this).text();
  $(this).parents('.btn-group').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
});
$(document).ready(function(){
    $("#esection2").click(function(){
        $("#excel_section2").slideDown("slow");
        $("#single_section2").hide("slow");
    });
});
$(document).ready(function(){
    $("#ssection2").click(function(){
        $("#single_section2").slideDown("slow");
        $("#excel_section2").hide("slow");
    });
});

//pie
var ctxP = document.getElementById("pieChart").getContext('2d');
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
//line
var ctxL = document.getElementById("lineChart").getContext('2d');
var myLineChart = new Chart(ctxL, {
    type: 'line',
    data: {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [{

              label: "做題題數",
              backgroundColor : "rgba(220,220,220,0.2)",
              borderWidth : 2,
              borderColor : "rgb(255, 187, 51)",
              pointBackgroundColor : "",
              pointBorderColor : "",
              pointBorderWidth : 1,
              pointRadius : 4,
              pointHoverBackgroundColor : "rgb(255, 187, 51)",
              pointHoverBorderColor : "rgb(255, 187, 51)",
              data: [65, 59, 80, 81, 56, 55, 40]

        }],



    },
    options: {
        responsive: true
    }
});
</script>

@endsection
@endif
