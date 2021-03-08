@extends('layout.admin_layout')

@section('css')
<style media="screen">

.main_area{
    background-color:#fff;
}
.form-control{
  background-color:#fbf8f2;
}
</style>
@endsection

@section('content')
  <center><h3>班級管理</h3></center><br>
  @if (session('alert'))
      <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          {{ session('alert') }}<br>{{ session('tx') }}
      </div>
  @endif
   <center>
     <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
       <span class="glyphicon glyphicon-plus-sign"></span><h4>新增班級</h4>
     </button>
   </center>
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">新增班級</h4>
          </div>
          <form action="{{ url('admin/user_lists') }}" method="post">
            {{ csrf_field() }}
            <div class="modal-body">
                  <h4><strong><code>*</code>學年度:</strong></h4>
                  <div class="form-group">
                    <input class="form-control"  type="text" name="school_year"  placeholder="ex : 1051、1052、1061、1062" required>
                  </div>
                  <input type="hidden" name="admin_id" value="{{ Auth::guard('admin')->user()->id }}">
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary btn-sm">+確認新增</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </form>
        </div>

      </div>
    </div>

  </div>

  </center><br>
  <div class="row">
    <div class="col-sm-1">

    </div>
    <div class="col-sm-10">
      <div class="main_area">
        <table class="table">
   <thead style="background-color:#3b3735;color:#fff">
     <tr>
       <th><h4>學年度</h4></th>
       <th><h4>/&nbsp;</h4></th>
       <th><h4>/&nbsp;</h4></th>
       <th><h4>/&nbsp;</h4></th>
       <th><h4>/&nbsp;</h4></th>
     </tr>
   </thead>
   <tbody>
     @foreach($courses as $course)
     <tr>
       <td><h5>{{$course->school_year}}</h5></td>
        <td>
          <a href="{{ url('admin/user_lists/'.$course->id) }}">
            <h5><button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#myModal{{$course->id}}">
              <span class="glyphicon glyphicon-eye-open"></span>&nbsp;查看詳情
            </button></h5>
          </a>
        </td>
        <td>
          <a href="{{ url('admin/select_question/'.$course->id) }}">
             <h5><button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#myModal{{$course->id}}">
              <span class="glyphicon glyphicon-check"></span>&nbsp;勾選題目
            </button></h5>
          </a>
        </td>
        <td>
          <a href="{{ url('admin/newsedit/'.$course->id) }}">
             <h5><button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#myModal{{$course->id}}">
              <span class="glyphicon glyphicon-envelope"></span>&nbsp;發布公告
            </button></h5>
          </a>
        </td>
        <td>
          <form action="{{ url('admin/user_lists/'.$course->id) }}" method="POST">
                {!! csrf_field() !!}
                {!! method_field('DELETE') !!}
              <h5><button type="submit" id="delete-category-{{ $course->id }}" class="btn btn-danger btn-sm">
                  <span class="glyphicon glyphicon-trash"></span>刪除
              </button></h5>
          </form>
        </td>
          </tr>
     @endforeach

   </tbody>
  </table>
    </div>
    <div class="col-sm-1">

    </div>

  </div>
@endsection
