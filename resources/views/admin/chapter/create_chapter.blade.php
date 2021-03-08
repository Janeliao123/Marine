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
      <center><h3><span class="glyphicon glyphicon-edit"></span>&nbsp;章管理</h3></center>
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
            <form class="" action="{{ url('admin/chapter') }}" method="post">
                {{ csrf_field() }}
                <lable>
                    <h4><strong>*章節名稱:</strong></h4>
                </lable>
                <input class="form-control input-lg" type="text" name="title" placeholder="第x章、xxxx" required><br>
                <input type="hidden" name="admin_id"  value="{{Auth::guard('admin')->user()->id}}" required><br>
                <button type="submit" class="btn btn-primary btn-sm btn-block">
                    <span class="glyphicon glyphicon-plus">確認新增
                </button>
            </form>
          </div>
        </div>
        <div class="col-sm-2"></div>
      </div><br>
    <div class="row">
      <div class="col-sm-2"></div>
      <div class="col-sm-8">
        <div class="main_area">
            <table class="table">
             <thead>
               <tr>
                 <th>章節名稱</th>
                 <th>新增者</th>
                 <th>/&nbsp;</th>
                 <th>/&nbsp;</th>
               </tr>
             </thead>
             <tbody>
               @foreach($chapter as $chapter)
               <tr>
                   @if(Auth::guard('admin')->user()->id == $chapter->admin_id)
                   <form action="{{ url('admin/chapter/'.$chapter->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                   <td><input class="form-control" type="text" name="title" value="{{ $chapter->title }}"></td>
                   <td>{{ $chapter->name }}</td>
                   <td>
                    		<button type="submit" class="btn btn-default btn-sm">
                    				<span class="glyphicon glyphicon-pencil"></span>確認變更
                    		</button>
                    </td>
                    </form>
                  @else
                    <td>{{ $chapter->title }}</td>
                    <td>{{ $chapter->name }}</td>
                    <td></td>

                  @endif
                  <td>
                    @if(Auth::guard('admin')->user()->id == $chapter->admin_id)
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delModal{{$chapter->id}}">
                      <span class="glyphicon glyphicon-exclamation-sign"></span> 刪除
                    </button>
                    <!-- Modal -->
                    <div id="delModal{{$chapter->id}}" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4>確認刪除{{ $chapter->title }}?</h4>
                          </div>
                          <div class="modal-body">
                            <form action="{{ url('admin/chapter/'.$chapter->id) }}" method="POST">
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
