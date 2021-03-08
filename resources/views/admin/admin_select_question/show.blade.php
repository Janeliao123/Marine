@extends('layout.admin_layout')

@section('css')
<link href="/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<style media="screen">

.main_area{
    background-color:#fff;
}
</style>
@endsection

@section('content')
  <center><h3>{{$year}}學年班級題目地圖</h3></center><br>
  <center><a href="{{ url('admin/select_question/select/'.$id) }}">
    <button type="button" class="btn btn-success btn-sm">
      <h4><span class="glyphicon glyphicon-edit"></span>&nbsp;勾選題目</h4>
    </button>
  </a></center><br>
  <div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-8">
      <div class="main_area">

        <table class="table">
           <thead>
             <tr>
               <th></th>
             </tr>
           </thead>
           <tbody>
             @foreach($chapter as $chapters)
             <tr>
               <td>
                  <center><h3>{{$chapters->title}}</h3></center>
                    @foreach($section as $sections)
                        @if($sections->chapter_id == $chapters->id)
                            <br><h4>{{$sections->title}}</h4>
                            <?php $i = 1; ?>
                            @foreach($questions as $question)
                              @if($question->section_id == $sections->id)
                                <h4 style="color:rgb(87, 151, 212);margin-left:20px;">#{{$i}}&nbsp;{{$question->title}}</h4>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#timeModal{{$question->aid}}">
                                  @if(is_null($question->due_date))
                                    設定提交時間
                                  @else
                                    截止時間:{{$question->due_date}}
                                  @endif
                                </button>
                                <a href="{{ url('admin/select_question/showHW') }}/{{$id}}/{{$question->id}}">
                                  <button type="submit" class="btn btn-primary">提交狀況</button>
                                </a>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal{{$question->aid}}">刪除</button>
                                <!-- Modal -->
                                <div id="myModal{{$question->aid}}" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4>確認刪除?</h4>
                                      </div>
                                      <div class="modal-body">
                                        <form action="{{ url('admin/select_question/'.$question->aid) }}" method="POST">
                                                {!! csrf_field() !!}
                                                {!! method_field('DELETE') !!}
                                            <button type="submit" class="btn btn-danger btn-sm btn-block">
                                                <span class="glyphicon glyphicon-trash"></span> 刪除
                                            </button>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div id="timeModal{{$question->aid}}" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4>設定繳交截止時間</h4>
                                      </div>
                                      <div class="modal-body">
                                        <form action="{{ url('admin/select_question/due_date/store') }}" method="POST">
                                                {!! csrf_field() !!}
                                            <div class="form-group">
                                              <code>*</code><label>截止時間:</label>
                                              <div class="input-append date form_datetime">
                                                  @if(is_null($question->due_date))
                                                    <input size="16" type="text" value="" name="due_date" readonly required>
                                                  @else
                                                    <input size="16" type="text" value="{{$question->due_date}}" name="due_date" readonly required>
                                                  @endif
                                                  <span class="add-on"><i class="icon-th"></i></span>
                                              </div>

                                              <script type="text/javascript">
                                                  $(".form_datetime").datetimepicker({
                                                      format: "dd MM yyyy - hh:ii",
                                                      autoclose: true,
                                                      todayBtn: true,
                                                      pickerPosition: "bottom-left"
                                                  });
                                              </script>
                                            </div>
                                            <input type="hidden" name="ad_id" value="{{$question->aid}}">
                                            <button type="submit" class="btn btn-primary btn-sm btn-block">
                                                <span class="glyphicon glyphicon-trash"></span>提交
                                            </button>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              @endif
                              <?php $i = $i+1; ?>
                            @endforeach
                        @endif
                    @endforeach
                </td>
              </tr>
             @endforeach


           </tbody>
        </table>
      </div>
    </div>
    <div class="col-sm-2"></div>
  </div>
@endsection
@section('js')
<script type="text/javascript" src="/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="/js/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
	$('.form_date').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	$('.form_time').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
    });
</script>
@endsection
