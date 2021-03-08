@extends('layout.layout')
@section('css')
<style media="screen">

#banner {
  background-image: url('dis.png') !important;
}

 .list-group-item-top{
   background-color:#435761;
 }
 .category-logo{

    height: 150px;
    float: left;
    margin: 15px;
    /* margin-right: 15px; */
 }
 .category-name{
    display: inline-block;
    max-width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    vertical-align: text-top;
    line-height: 1.2;
    border-bottom:solid 2px gray;
 }
 .category-element{
   border-left:solid 6px #9EB83B;
 }
 .dis_title{
   background-color:#9EB83B;
   width: 150px;
   height: 150px;
   padding: 40px;
   text-align: center;
   color: #fff;
   font-size: 40pt;
   box-shadow: 7px 7px 5px #e6e6e6;
 }
 .back_btn{
   background-color:#cccccc;
   width: 150px;
   height: 40px;
   padding: 10px;
   text-align: center;
   color: #fff;
   font-size: 12pt;
   box-shadow: 7px 7px 5px #e6e6e6;
 }


/* Add a card effect for articles */
.card {
     background-color: white;
     padding: 20px;
     margin-top: 20px;
     border-radius: 20px;
     font-size: 24px;
}

/* Clear floats after the columns */
.row:after {
    content: "";
    display: table;
    clear: both;
}

textarea{
    width: 80%;
    height: 150px;
    padding: 20px;
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
    font-size: 18px;
    resize: none;
}

.button {
  display: inline-block;
  border-radius: 4px;
  background-color: #000000;
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 20px;
  padding: 20px;
  width: 200px;
  transition: all 0.5s;
  cursor: pointer;
  margin: 5px;
}

.button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.button span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.button:hover span {
  padding-right: 25px;
}

.button:hover span:after {
  opacity: 1;
  right: 0;
}
</style>

@endsection
@section('content')
<div class="container-body">
  <br>
  <div class="row">
    <div class="col-sm-2"><div class="dis_title">Q</div>
    <br><a href="{{url('discussion')}}"><div class="back_btn">回討論區</div></a></div>
    <div class="col-sm-8">
    <div class="row">
      <h1>新增提問</h1>
    <div class="card">
      <form action="{{url('admin/discussionask')}}" method="post">
        {{ csrf_field() }}

        <input type="hidden" name="chapter" value="{{$id}}">
        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
        提問主題:<br>
        <input type="text" name="title" placeholder="請輸入標題...">
        <br>

        提問內容:<br>
        <script src="/ckeditor5-build-classic/ckeditor.js"></script>

          <textarea name="ask_content" id="editor">
              請輸入文字...
          </textarea>
        <script>
            ClassicEditor
                .create( document.querySelector( '#editor' ) )
                .catch( error => {
                    console.error( error );
                } );

        </script>



        <br>
        <br>
          <button class="button" style="vertical-align:middle" type="submit"><span>新增提問</span></button>
          <button class="button" style="vertical-align:middle"><span>取消提問</span></button>
      </form>
    </div>
    </div>
    <div class="col-sm-2"></div>
  </div>
</div>

@endsection
