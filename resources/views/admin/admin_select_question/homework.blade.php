@extends('layout.admin_layout')

@section('css')
<style media="screen">

.main_area{
    background-color:#fff;
}
</style>
@endsection

@section('content')
  <center><h3>作業繳交狀況</h3><a href="{{ url('admin/select_question/downloadHW/'.$course_select_question->id) }}" target="_blank">
    <button type="button" class="btn btn-primary">匯出壓縮檔</button></a>
  </center><br>
  <div class="row">
    <div class="col-sm-2"></div>

    <div class="col-sm-8 main_area">
      <h3>題目:{{$question_name}} </h3>
      <div class="row">
        @if(isset($no_register))
          <div class="col-sm-3 main_area">
            <h4>
              <span class="glyphicon glyphicon-remove-circle" style="color:#ff1a1a;font-size:20px"></span>
              <span class="glyphicon glyphicon-remove-circle" style="color:#ff1a1a;font-size:20px"></span>
              未註冊學號:
            </h4>
            <ol>
              @foreach($no_register as $no_registers)
                <li>{{$no_registers->acct}}-{{$no_registers->name}}</li>
              @endforeach
            </ol>
          </div>
        @endif
        <div class="col-sm-3">
          <h4><span class="glyphicon glyphicon-ok-circle" style="color:#00cc99;font-size:20px"></span>提交學號:</h4>
          <ol>
            @foreach($homeworks as $homework)
              <li>{{$homework->acct}}-{{$homework->name}}</li>
            @endforeach
          </ol>
        </div>
        @if(isset($no_ans))
          <div class="col-sm-3">
            <h4>
              <span class="glyphicon glyphicon-remove-circle" style="color:#ff1a1a;font-size:20px"></span>
              未提交學號:
            </h4>
            <ol>
              @foreach($no_ans as $no_an)
                <li>{{$no_an->acct}}-{{$no_an->name}}</li>
              @endforeach
            </ol>
          </div>
        @endif

      </div>
    </div>

    <div class="col-sm-2"></div>
  </div>






@endsection
