@extends('layout.admin_layout')

@section('css')
<style media="screen">
  label{
    font-size: 18px;
  }
</style>
@endsection

@section('content')
<center><h3><span class="glyphicon glyphicon-pencil"></span>修改題目區</h3></center>
  <form class="" action="{{ url('admin/question/'.$question->id) }}" method="post">
      {{ csrf_field() }}
      {{ method_field('PATCH') }}
      <div class="form-group">
        <code>*</code><label >標題:</label>
        <input type="text" class="form-control" name="title" value="{{ $question->title }}" required>
      </div>
      <div class="form-group">
        <code>*</code><label >題目是否公開:</label>
        <select class="selectpicker" name="is_public" required>
            <option value="1" @if( $question->is_public == 1) selected @endif>公開</option>
            <option value="0" @if( $question->is_public == 0) selected @endif>隱藏</option>
        </select><br><code>若選擇隱藏則只有自己班的學生會看到該題目</code>
      </div>
      <div class="form-group">
        <code>*</code><label >所屬章節:</label>
        <select class="selectpicker" name="section_id" required>
          @foreach($chapter as $chapter)
            <optgroup label="{{ $chapter->title }}">
              @foreach($section as $sections)
                @if($sections->chapter_id == $chapter->id)
                  <option value="{{$sections->id}}" @if( $sections->id == $question->section_id) selected @endif>{{$sections->title}}</option>
                @endif
              @endforeach
            </optgroup>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <code>*</code><label >題目型態:</label>
        <select class="selectpicker" name="type" required>
            <option value="1" @if( $question->type == 1) selected @endif>生活型</option>
            <option value="2" @if( $question->type == 2) selected @endif>學術型</option>
        </select>
      </div>
      <div class="form-group">
        <code>*</code><label >提示:</label>
        <input type="text" class="form-control" name="hint" value="{{ $question->hint }}" required>
      </div>
      <div class="form-group">
        <code>*</code><label >包含章節:</label>
        <input type="text" class="form-control" name="include" value="{{ $question->include }}" required>
      </div>
      <div class="form-group">
        <code>*</code><label>難易度:</label>
        <select class="selectpicker" name="difficulty" required>
            <option value="3" @if( $question->difficulty == 3) selected @endif>難</option>
            <option value="2" @if( $question->difficulty == 2) selected @endif>中</option>
            <option value="1" @if( $question->difficulty == 1) selected @endif>易</option>
        </select>
      </div>
      <div class="form-group">
        <code>*</code><label >題目敘述:</label>
<!--           <script src="https://cdn.ckeditor.com/ckeditor5/11.0.1/decoupled-document/ckeditor.js"></script>
            <div id="document-editor">
                <div id="document-editor__toolbar"></div>
                <div id="document-editor__editable-container" >
                  <textarea id="document-editor__editable" class="form-control" rows="5" name="content" required>{!! $question->content !!}</textarea>
                </div>
            </div>
            <script>
                DecoupledEditor
                    .create( document.querySelector( '#document-editor__editable' ) )
                    .then( editor => {
                        const toolbarContainer = document.querySelector( '#document-editor__toolbar' );

                        toolbarContainer.appendChild( editor.ui.view.toolbar.element );

                        window.editor = editor;
                    } )
                    .catch( err => {
                        console.error( err );
                    } );
            </script> -->
          <script src="/ckeditor5-build-classic/ckeditor.js"></script>

          <textarea class="form-control" rows="5" name="content" required id="editor">
              {!! $question->content !!}
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
      <div class="form-group">
        <label >範例解答(答案非唯一):</label>
        <textarea class="form-control" rows="5" name="answer" >{{ $question->answer }}</textarea>
      </div>
      <div class="form-group">
        <label >input:</label>
        <textarea class="form-control" rows="5" name="input_student" >{{ $question->input_student }}</textarea>
      </div>
      <div class="form-group">
        <label >ouput:</label>
        <textarea class="form-control" rows="5" name="output_student" >{{ $question->output_student }}</textarea>
      </div>
      <div class="form-group">
        <label >input:</label>
        <textarea class="form-control" rows="5" name="input_admin" >{{ $question->input_admin }}</textarea>
      </div>
      <div class="form-group">
        <label >ouput:</label>
        <textarea class="form-control" rows="5" name="output_admin" >{{ $question->output_admin }}</textarea>
      </div>
      <button type="submit" class="btn btn-primary btn-lg btn-block"><h5><span class="glyphicon glyphicon-pencil"></span>確認修改</h5></button>
  </form>
  <br><br>
@endsection
