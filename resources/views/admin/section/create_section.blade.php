@extends('layout.admin_layout')
@section('css')
<style media="screen">

.main_area{
    background-color:#fff;
    padding:20px;
    border-radius:10px;
}
</style>
@endsection
@section('content')
    <center><h3><span class="glyphicon glyphicon-edit"></span>&nbsp;節管理</h3></center>
    @if (count($errors) > 0)
     <div class="alert alert-danger alert-block">
       <button type="button" class="close" data-dismiss="alert">×</button>
         <ul>
             @foreach ($errors->all() as $error)
                 <li>{{ $error }}</li>
             @endforeach
         </ul>
     </div>
    @endif
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
          <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
        </div>
    @endif
    <div class="row">
      <div class="col-sm-2"></div>
      <div class="col-sm-8">
        <div class="main_area" >
          <form class="" action="{{ url('admin/section') }}" method="post">
            {{ csrf_field() }}
              <div class="row">
                <lable>
                  <h4><strong>所屬章節:</strong></h4>
                </lable>
                  <select class="selectpicker" name="chapter_id">
                    <!-- <optgroup label="Picnic"> -->
                    @foreach($chapter as $chapter)
                      <option value="{{ $chapter->id }}">{{ $chapter->title }}</option>
                    @endforeach
                    </optgroup>
                  </select>
              </div><br>
              <div class="row">
                <lable>
                    <h4><strong>小節名稱:</strong></h4>
                </lable>
                <input class="form-control input-lg" id="inputlg" type="text" name="title" placeholder="5-1、xxxx" required><br>
                <input type="hidden" name="admin_id"  value="{{Auth::guard('admin')->user()->id}}" required><br>
                <button type="submit" class="btn btn-primary btn-sm btn-block">
                    +確認新增
                </button>
              </div>
          </form>
        </div>
      </div>
      <div class="col-sm-2"></div>
    </div>
  <br>
  <div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-8">
      <div class="main_area" >
          <table class="table">
             <thead>
               <tr>
                 <th>小節名稱</th>
                 <th>新增者</th>
                 <th>&nbsp;</th>
                 <th>&nbsp;</th>
               </tr>
             </thead>
             <tbody>
               @foreach($join as $join)
                   <tr>
                     @if(Auth::guard('admin')->user()->id == $join->admin_id)
                         <form action="{{ url('admin/section/'.$join->s_id) }}" method="post">
                              {{ csrf_field() }}
                              {{ method_field('PATCH') }}
                         <td>{{ $join->c_title }}--<input class="form-control" type="text" name="title" value="{{ $join->s_title }}"></td>
                         <td>{{ $join->name }}</td>
                         <td>
                              <button type="submit" class="btn btn-default btn-sm">
                                  <span class="glyphicon glyphicon-pencil"></span>確認變更
                              </button>
                          </td>
                          </form>
                      @else
                        <td>{{ $join->s_title }}</td>
                        <td></td>
                      @endif
                      <td>
                        @if(Auth::guard('admin')->user()->id == $join->admin_id)
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delModal{{$join->s_id}}">
                          <span class="glyphicon glyphicon-exclamation-sign"></span> 刪除
                        </button>
                        <!-- Modal -->
                        <div id="delModal{{$join->s_id}}" class="modal fade" role="dialog">
                          <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4>確認刪除{{ $join->s_title }}?</h4>
                              </div>
                              <div class="modal-body">
                                <form action="{{ url('admin/section/'.$join->s_id) }}" method="POST">
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
                        @endif
                      </td>

                   </tr>
               @endforeach
             </tbody>
          </table>
      </div>
    </div>
    <div class="col-sm-2"></div>
  </div><br><br>
@endsection
