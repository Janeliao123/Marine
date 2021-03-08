@extends('layout.admin_layout')

@section('css')
<style media="screen">

.main_area{
    background-color:#fff;
}
</style>
@endsection

@section('content')
    <center><span class="title"><h3>題目管理區</h3></span></center><br>
    <center><a href="{{url('admin/question/create')}}">
      <button type="button" class="btn btn-default btn-sm">
        <h4><span class="glyphicon glyphicon-plus">新增題目</h4>
      </button>
    </a></center><br>

      <div class="row">
        <div class="col-sm-2">

        </div>
        <div class="col-sm-8">
          <div class="main_area">
            <table class="table">
             <thead>
               <tr>
                 <th><h4>題目名稱</h4></th>
                 <th>/&nbsp;</th>
               </tr>
             </thead>
             <tbody>
               @foreach($question as $key => $question)
               <tr>
                 <td><a href="{{ url('compiler') }}?qid={{$question->id}}"><h5>{{$key+1}}、{{$question->title}}</a></h5></td>
                  <td>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <form action="{{ url('admin/question/'.$question->id.'/edit') }}" method="GET">
                                <button type="submit" id="edit-category-{{ $question->id }}" class="btn btn-warning btn-sm">
                                  <span class="glyphicon glyphicon-pencil"></span>修改
                                </button>
                             </form>
                          </div>
                          <div class="col-sm-3">
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delModal{{$question->id}}">
                              <span class="glyphicon glyphicon-exclamation-sign"></span> 刪除
                            </button>
                            <!-- Modal -->
                            <div id="delModal{{$question->id}}" class="modal fade" role="dialog">
                              <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4>確認刪除{{$question->title}}?</h4>
                                  </div>
                                  <div class="modal-body">
                                    <form action="{{ url('admin/question/'.$question->id) }}" method="POST">
                                        {!! csrf_field() !!}
                                        {!! method_field('DELETE') !!}
                                        <button type="submit" id="delete-category-{{ $question->id }}" class="btn btn-danger btn-sm btn-block">
                                            <span class="glyphicon glyphicon-trash"></span>刪除
                                        </button>
                                    </form>
                                  </div>

                                </div>

                              </div>
                            </div>


                          </div>
                        </div>
                      </td>
                    </tr>
               @endforeach
             </tbody>
            </table>
          </div>
        </div>
        <div class="col-sm-2">

        </div>

      </div>


@endsection
