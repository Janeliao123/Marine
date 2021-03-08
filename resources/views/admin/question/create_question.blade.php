@extends('layout.admin_layout')

@section('css')
<style media="screen">
  label{
    font-size: 18px;
  }
#document-editor {
    border: 1px solid var(--ck-color-base-border);
    border-radius: var(--ck-border-radius);

    /* Set vertical boundaries for the document editor. */
    max-height: 700px;

    /* This element is a flex container for easier rendering. */
    display: flex;
    flex-flow: column nowrap;
}
#document-editor__toolbar {
    /* Make sure the toolbar container is always above the editable. */
    z-index: 1;

    /* Create the illusion of the toolbar floating over the editable. */
    box-shadow: 0 0 5px hsla( 0,0%,0%,.2 );

    /* Use the CKEditor CSS variables to keep the UI consistent. */
    border-bottom: 1px solid var(--ck-color-toolbar-border);
}

/* Adjust the look of the toolbar inside the container. */
#document-editor__toolbar .ck-toolbar {
    border: 0;
    border-radius: 0;

}
#document-editor__editable-container {
    padding: calc( 2 * var(--ck-spacing-large) );
    background: var(--ck-color-base-foreground);
    /* Make it possible to scroll the "page" of the edited content. */
    overflow-y: scroll;
}

#document-editor__editable-container .ck-editor__editable {
    /* Set the dimensions of the "page". */
    width: 20cm;
    min-height: 10cm;

    /* Keep the "page" off the boundaries of the container. */
    padding: 1cm 2cm 2cm;

    border: 1px hsl( 0,0%,82.7% ) solid;
    border-radius: var(--ck-border-radius);
    background: white;

    /* The "page" should cast a slight shadow (3D illusion). */
    box-shadow: 0 0 5px hsla( 0,0%,0%,.1 );

    /* Center the "page". */
    margin: 0 auto;
}
#document-editor .ck-content,
#document-editor .ck-heading-dropdown .ck-list .ck-button__label {
    font: 16px/1.6 "Helvetica Neue", Helvetica, Arial, sans-serif;
}
#document-editor .ck-heading-dropdown .ck-list .ck-button__label {
    line-height: calc( 1.7 * var(--ck-line-height-base) * var(--ck-font-size-base) );
    min-width: 6em;
}

/* Scale down all heading previews because they are way too big to be presented in the UI.
Preserve the relative scale, though. */
#document-editor .ck-heading-dropdown .ck-list .ck-button:not(.ck-heading_paragraph) .ck-button__label {
    transform: scale(0.8);
    transform-origin: left;
}

/* Set the styles for "Heading 1". */
#document-editor .ck-content h2,
#document-editor .ck-heading-dropdown .ck-heading_heading1 .ck-button__label {
    font-size: 2.18em;
    font-weight: normal;
}

#document-editor .ck-content h2 {
    line-height: 1.37em;
    padding-top: .342em;
    margin-bottom: .142em;
}

/* Set the styles for "Heading 2". */
#document-editor .ck-content h3,
#document-editor .ck-heading-dropdown .ck-heading_heading2 .ck-button__label {
    font-size: 1.75em;
    font-weight: normal;
    color: hsl( 203, 100%, 50% );
}

#document-editor .ck-heading-dropdown .ck-heading_heading2.ck-on .ck-button__label {
    color: var(--ck-color-list-button-on-text);
}

/* Set the styles for "Heading 2". */
#document-editor .ck-content h3 {
    line-height: 1.86em;
    padding-top: .171em;
    margin-bottom: .357em;
}

/* Set the styles for "Heading 3". */
#document-editor .ck-content h4,
#document-editor .ck-heading-dropdown .ck-heading_heading3 .ck-button__label {
    font-size: 1.31em;
    font-weight: bold;
}

#document-editor .ck-content h4 {
    line-height: 1.24em;
    padding-top: .286em;
    margin-bottom: .952em;
}

/* Set the styles for "Paragraph". */
#document-editor .ck-content p {
    font-size: 1em;
    line-height: 1.63em;
    padding-top: .5em;
    margin-bottom: 1.13em;
}
#document-editor .ck-content blockquote {
    font-family: Georgia, serif;
    margin-left: calc( 2 * var(--ck-spacing-large) );
    margin-right: calc( 2 * var(--ck-spacing-large) );
}
</style>
@endsection

@section('content')
  <div class="col-sm-1"></div>
  <div class="col-sm-10">
    <center><h3><span class="glyphicon glyphicon-pencil"></span>新增題目區</h3></center>
    <form action="{{ url('admin/question') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
          <code>*</code><label >標題:</label>
          <input type="text" class="form-control" name="title" required>
        </div>
        <div class="form-group">
          <code>*</code><label >題目是否公開:</label>
          <select class="selectpicker" name="is_public" required>
              <option value="1">公開</option>
              <option value="0">隱藏</option>
          </select><br><code>若選擇隱藏則只有自己班的學生會看到該題目</code>
        </div>
        <div class="form-group">
          <code>*</code><label >所屬章節:</label>
          <select class="selectpicker" name="section_id" required>
            @foreach($chapter as $chapter)
              <optgroup label="{{ $chapter->title }}">
                @foreach($section as $sections)
                  @if($sections->chapter_id == $chapter->id)
                    <option value="{{$sections->id}}">{{$sections->title}}</option>
                  @endif
                @endforeach
              </optgroup>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <code>*</code><label >題目型態:</label>
          <select class="selectpicker" name="type" required>
              <option value="1">生活型</option>
              <option value="2">學術型</option>
          </select>
        </div>
        <div class="form-group">
          <code>*</code><label >提示:</label>
          <input type="text" class="form-control" name="hint" required>
        </div>
        <div class="form-group">
          <code>*</code><label >包含章節:</label>
          <input type="text" class="form-control" name="include" required>
        </div>
        <div class="form-group">
          <code>*</code><label >難易度:</label>
          <select class="selectpicker" name="difficulty" required>
              <option value="3">難</option>
              <option value="2">中</option>
              <option value="1">易</option>
          </select>
        </div>
        <div class="form-group">
          <code>*</code><label >題目敘述:</label>
          <script src="/ckeditor5-build-classic/ckeditor.js"></script>
          <textarea class="form-control" rows="8" name="content" required id="editor">
              請輸入題目內容...
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
          <textarea class="form-control" rows="5" name="answer" ></textarea>
        </div>
        <div class="form-group">
          <label >input:</label>
          <textarea class="form-control" rows="5" name="input_student" ></textarea>
        </div>
        <div class="form-group">
          <label >ouput:</label>
          <textarea class="form-control" rows="5" name="output_student" ></textarea>
        </div>
        <div class="form-group">
          <label >input:</label>
          <textarea class="form-control" rows="5" name="input_admin" ></textarea>
        </div>
        <div class="form-group">
          <label >ouput:</label>
          <textarea class="form-control" rows="5" name="output_admin" ></textarea>
        </div>
        <input type="hidden" class="form-control" name="admin_id" value="{{Auth::guard('admin')->user()->id}}" required>
        <button type="submit" class="btn btn-primary btn-lg btn-block"><h5>+確認新增</h5></button>
    </form>
  <br><br>
  </div>
  <div class="col-sm-1"></div>
@endsection
