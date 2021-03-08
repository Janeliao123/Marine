@extends('layout.admin_layout')
@section('css')

@endsection




@section('content')
<div>
  <h3>新增公告</h3>
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
  <br>
  <form class="" action="{{ url('admin/newsedit') }}" method="POST">
      {{ csrf_field() }}
      <input type="hidden" name="admin_id" value="{{Auth::guard('admin')->user()->id}}">
      <div class="col-sm-1">
          <strong>公告名稱:</strong>
      </div>
      <div class="col-sm-8">
          <input class="form-control input-sm" id="inputlg" type="text" name="title">
      </div>
      <br><br>
      <div class="col-sm-1">
          <strong>公告種類:</strong>
      </div>
      <div class="col-sm-4">
        <select class="selectpicker" name="course_id" required>
            <option value="{{$course_id}}">班級公告</option>
            <option value="0">公開公告</option>
        </select>
      </div><br><br>

      <div class="col-sm-1">
          <strong>內容:</strong>
      </div>
      <div class="col-sm-8">
        <script src="/ckeditor5-build-classic/ckeditor.js"></script>
          <textarea class="form-control" rows="8" name="content" id="editor">
              請輸入公告內容...
          </textarea>
        <script>
            var myEditor;
            ClassicEditor
                .create( document.querySelector( '#editor' ) )
                .catch( error => {
                    console.error( error );
                } );
        </script>
      </div>
      <br><br><br><br><br><br><br>
      <center>
      <div class="col-sm-6">
        <button type="submit" class="btn btn-primary btn-sm">
          +確認新增
        </button>
      </div>
    </center>
  </form>
</div>

<br><br>


<table class="table">
 <thead>
   <tr>
     <th>公告名稱</th>
     <th>/&nbsp;</th>
     <th>/&nbsp;</th>
   </tr>
 </thead>
 <tbody>
   @foreach($allnews as $allnew)
   <tr>
     <form action="{{ url('admin/newseditsecond/'.$allnew->id) }}" method="get">
          {{ csrf_field() }}
          {{ method_field('PATCH') }}
     <td>{{ $allnew->title }}</td>
     <td>
          <button type="submit" class="btn btn-default btn-sm">
              <span class="glyphicon glyphicon-pencil"></span>編輯公告
          </button>
      </td>
      </form>
      <td>
        <form action="{{ url('admin/news_delete/'.$allnew->id) }}" method="POST">
                {!! csrf_field() !!}
                {!! method_field('DELETE') !!}
            <button type="submit" class="btn btn-danger btn-sm">
                <span class="glyphicon glyphicon-trash"></span> 刪除
            </button>
        </form>
      </td>

   </tr>
   @endforeach
 </tbody>
</table>




@endsection
