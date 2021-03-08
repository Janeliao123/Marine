@extends('layout.admin_layout')
@section('css')

@endsection


@section('content')





<table>
  <tr>
  <form action="{{ url('admin/newseditsecond/'.$data->id)}}" method="post">
       {{ csrf_field() }}
  <td><input class="form-control" type="text" name="title" value="{{ $data->title }}"></td>
  <tr>
  <td>
    <script src="/ckeditor5-build-classic/ckeditor.js"></script>
          <textarea class="form-control" rows="8" name="content" id="editor">
              {!!$data->content!!}
          </textarea>
        <script>
            var myEditor;
            ClassicEditor
                .create( document.querySelector( '#editor' ) )
                .catch( error => {
                    console.error( error );
                } );
        </script>
  </td>
</tr>


  <td>
       <button type="submit" class="btn btn-default btn-sm">
           <span class="glyphicon glyphicon-pencil"></span>確認變更
       </button>
   </td>
 </tr>


   </form>
</table>
@endsection
