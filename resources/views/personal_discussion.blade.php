@extends('layout.layout')
@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<style media="screen">
@import url('https://fonts.googleapis.com/css?family=Open+Sans:400,600,700');
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

.brand-logo{
   border-left:2px solid #000;
   border-bottom:2px solid #000;
   margin-left: 5%;
 }


*, *:before, *:after {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

section {
  display: none;
  padding: 20px 0 0;
  border-top: 1px solid #ddd;
}

input {
  display: none;
}

label {
  font-size: 16px;
  display: inline-block;
  margin: 0 0 -1px;
  padding: 15px 25px;
  font-weight: 600;
  text-align: center;
  color: #bbb;
  border: 1px solid transparent;
}

label:before {
  font-family: fontawesome;
  font-weight: normal;
  margin-right: 10px;
}

label[for*='1']:before { content: '\f005'; }
label[for*='2']:before { content: '\f02d'; }
label[for*='3']:before { content: '\f059'; }


label:hover {
  color: #6699A1;
  cursor: pointer;
}

input:checked + label {
  color: #555;
  border: 1px solid #ddd;
  border-top: 2px solid #78C2C4;
  border-bottom: 1px solid #fff;
}

#tab1:checked ~ #content1,
#tab2:checked ~ #content2,
#tab3:checked ~ #content3,
#tab4:checked ~ #content4 {
  display: block;
}

@media screen and (max-width: 650px) {
  label {
    font-size: 0;
  }
  label:before {
    margin: 0;
    font-size: 18px;
  }
}

li {
    float: left;
}

  /* Create three equal columns that floats next to each other */
.column {
     /* float: left;
     width: 30%; */
     height: 40%;
     background-color:#fff;
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

</style>

@endsection
@section('content')
<div class="container" >
  <div class="row" >
  <br>
    <div class="column col-sm-12" style="background-color: rgb(211, 238, 242); border-radius: 10px;">
        <center>
          @if($stu_level > 45)  
          <img src="/img/level/6.PNG" style="border-radius:50%;  width:20% ; ">
          @elseif($stu_level > 30)
          <img src="/img/level/5.PNG" style="border-radius:50%;  width:20% ; ">
          @elseif($stu_level > 20)
          <img src="/img/level/4.PNG" style="border-radius:50%;  width:20% ; ">
          @elseif($stu_level > 10)
          <img src="/img/level/3.PNG" style="border-radius:50%;  width:20% ; ">
          @elseif($stu_level > 5)
          <img src="/img/level/2.PNG" style="border-radius:50%;  width:20% ; ">
          @else
          <img src="/img/level/1.PNG" style="border-radius:50%;  width:20% ; ">
          @endif
          <br><br>
          <i class="fa fa-address-book" style="font-size:25px"></i>
          <font size="5" style="color:gray"> 稱號:{{ Auth::user()->name }}</font>
        </center>
    </div>
    <div class="column col-sm-12" style="border-radius: 10px; margin-top: 10px; ">
        <input id="tab1" type="radio" name="tabs" checked>
        <label for="tab1">珍藏題目</label>
          
        <input id="tab2" type="radio" name="tabs">
        <label for="tab2">我的提交</label>
          
        <input id="tab3" type="radio" name="tabs">
        <label for="tab3">討論區發問管理</label>

          
        <section id="content1">
          <table class="table">
              <thead>
              <tr>
                <th>題目名稱</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
              </tr>
              </thead>
              <tbody>
              <tr>              
                @foreach($questions as $question)
                  <td><a href="{{ url('compiler') }}?qid={{$question->id}}">{{$question->title}}</a></td>
                @endforeach
                <!-- <form >
                  <td><input class="form-control" type="text" ></td>
                  <td>
                    <button type="submit" class="btn btn-default btn-sm">
                      <span class="glyphicon glyphicon-pencil"></span>作答
                    </button>
                  </td>
                  </form> -->
                  <!-- <td>
                    <form>
                        <button type="submit" class="btn btn-danger btn-sm">
                            <span class="glyphicon glyphicon-trash"></span> 刪除
                        </button>
                    </form>
                  </td> -->
                </tr>
            </tbody>
            </table>
        </section>
          
        <section id="content2">
          <table class="table">
            <thead>
              <tr>
                <th>題目(點擊以觀看程式碼)</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              @foreach($codes as $code)
                @if ($code->status=="AC")
                  <div class="panel panel-success">
                    <div class="panel-heading " data-toggle="collapse" data-target="#collapseArea{{$code->id}}" aria-expanded="false" aria-controls="collapseArea{{$code->id}}">
                      <span > 題目: {{$questions_title[$code->question_id-1]}}</span>
                      <span > 狀態: <span class="label label-success">正確</span> </span>
                      <span > 提交日期:{{$code->created_at}}</span>
                    </div>
                    <div class="panel-body collapse" id="collapseArea{{$code->id}}">
                      <code>
                      {!!$code->code!!}
                      </code>
                      <hr>
                      <button class="btn btn-default btn-sm">
                        <a href="{{url('/compiler?qid=').$code->question_id.'&oldCode='.$code->id}}"><span class="glyphicon glyphicon-pencil"></span>再寫一次</a>
                      </button>
                    </div>            
                  </div>
                @else
                <div class="panel panel-danger">
                    <div class="panel-heading " data-toggle="collapse" data-target="#collapseArea{{$code->id}}" aria-expanded="false" aria-controls="collapseArea{{$code->id}}">
                      <span > 題目: {{$questions_title[$code->question_id-1]}}</span>
                      <span > 狀態: <span class="label label-danger">錯誤</span> </span>
                      <span > 提交日期:{{$code->created_at}}</span>
                    </div>
                    <div class="panel-body collapse" id="collapseArea{{$code->id}}">
                      <code>
                      {!!$code->code!!}
                      </code>
                      <hr>
                      <button type="submit" class="btn btn-default btn-sm">
                      <a href="{{url('/compiler?qid=').$code->question_id.'&oldCode='.$code->id}}"><span class="glyphicon glyphicon-pencil"></span>再寫一次</a>
                      </button>
                    </div>
                  </div>
                @endif
              @endforeach
            </tbody>
          </table>
        </section>
          
        <section id="content3">
          <table class="table">
            <thead>
            <tr>
              <th>標題名稱</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <form >
                <td>
                  <input class="form-control" type="text" >
                </td>
                <td>
                  <button type="submit" class="btn btn-primary btn-sm">
                    <span class="glyphicon glyphicon-pencil"></span> 編輯
                  </button>
                </td>
                </form>
                <td>
                  <form>
                      <button type="submit" class="btn btn-danger btn-sm">
                          <span class="glyphicon glyphicon-trash"></span> 刪除
                      </button>
                  </form>
                </td>
              </tr>
          </tbody>
          </table>
        </section>
    </div>
  </div>
</div>
@endsection
