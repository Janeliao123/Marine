@extends('layout.admin_layout')

@section('css')
<style media="screen">
/* The container */
.container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #80ba86;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
.main_area{
    background-color:#fff;
}
</style>
@endsection

@section('content')
  <center><h3><span class="glyphicon glyphicon-check"></span>&nbsp;選取題目</h3><center><br>
  <form action="{{ url('admin/select_question') }}" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="course_list_id" value="{{$id}}">
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
                          <h3>{{$chapters->title}}</h3>
                          <?php $i=1?>
                            @foreach($section as $sections)
                                @if($sections->chapter_id == $chapters->id)
                                    <h4>{{$sections->title}}</h4>
                                    @foreach($question as $questions)
                                      @if($questions->section_id == $sections->id)
                                        @foreach( $selected_q as $q)
                                          @if($q->id == $questions->id)

                                          <label class="container" style="color: rgb(75, 128, 204);">
                                            {{$questions->title}}
                                            @if($questions->difficulty ==1 )
                                              <span class="w3-tag w3-small w3-yellow">
                                                易
                                              </span>
                                              @elseif($questions->difficulty ==2)
                                              <span class="w3-tag w3-small w3-blue">
                                                中
                                              </span>
                                              @else
                                              <span class="w3-tag w3-small w3-red">
                                                難
                                              </span>
                                              @endif
                                            <!-- <input type="checkbox" id="inlineCheckbox{{$questions->id}}" name="q_id[]" value="{{$questions->id}}" checked="checked"> -->
                                            <span class="checkmark">X</span>
                                          </label><br>
                                            <?php $i=0?>
                                          @endif
                                        @endforeach
                                        @if($i == 0)
                                        @else
                                        <label class="container">
                                          {{$questions->title}}
                                          @if($questions->difficulty ==1 )
                                          <span class="w3-tag w3-small w3-yellow">
                                            易
                                          </span>
                                          @elseif($questions->difficulty ==2)
                                          <span class="w3-tag w3-small w3-blue">
                                            中
                                          </span>
                                          @else
                                          <span class="w3-tag w3-small w3-red">
                                            難
                                          </span>
                                          @endif
                                          <input type="checkbox" id="inlineCheckbox{{$questions->id}}" name="q_id[]" value="{{$questions->id}}">
                                          <span class="checkmark"></span>
                                        </label><br>
                                        @endif
                                        <?php $i=1?>
                                      @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </td>
                      </tr>
                     @endforeach
                   </tbody>
               </table>
               <button type="submit" class="btn btn-primary btn-lg btn-block"><h5><span class="glyphicon glyphicon-plus"></span>&nbsp;確認新增</h5></button>
          </div>
        </div>
        <div class="col-sm-2"></div>
      </div>
  </form><br><br>
@endsection
