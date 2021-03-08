@extends('layout.layout')
@section('css')
<style media="screen">
#banner {
	background-image: url('img/coursemap.png') !important;
}
 
</style>

@endsection
@section('content')

<div id="banner"></div>
<div class="container-body">
<br>
<div class="row">
  <div class="col-sm-1">

  </div>
  <div class="col-sm-9">
    <center>
      <table style="width:100%">
        <thead>
          <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr style="border-bottom:solid 1px gray;border-top:solid 1px gray">
            <td class="category-element">
              <a href="{{url('discussion_sec')}}">
                <img class="category-logo" src="https://image.flaticon.com/icons/svg/91/91639.svg" >
              </a>
            </td>
            <td style="padding:15px">
              <span class="category-name">變數宣告</span>
            </td>
            <td>
              <span style="background-color:#66BAB7;color:#fff;padding:5px;font-size:12px">發問人數:6</span>
            </td>
            <td style="padding:15px">
            <h5><span style="font-weight:bold;">[Solved]</span>2018-09-21請問這題這樣寫對嗎?</h5>
              <h5><span style="font-weight:bold;">[Unsolved]</span>2018-09-21請問這題這樣寫對嗎?</h5>
            </td>
          </tr>
          <tr style="border-bottom:solid 1px gray">
            <td class="category-element" style="border-color:#D0956D">
              <img class="category-logo" src="https://image.flaticon.com/icons/svg/91/91617.svg" >
              <td style="padding:15px">
                <span class="category-name">變數宣告</span>
              </td>
              <td style="padding:15px">
                <span style="background-color:#66BAB7;color:#fff;padding:5px;font-size:12px">發問人數:6</span>
              </td>
              <td style="padding:15px">
                <h5><span style="font-weight:bold;">[Solved]</span>2018-09-21請問這題這樣寫對嗎?</h5>
                <h5><span style="font-weight:bold;">[Unsolved]</span>2018-09-21請問這題這樣寫對嗎?</h5>
              </td>
          </tr style="border-bottom:solid 1px gray">
          <tr>
            <td class="category-element" style="border-color:#669999">
              <img class="category-logo" src="https://image.flaticon.com/icons/svg/91/91611.svg" >
              <td style="padding:15px">
                <span class="category-name">變數宣告</span>
              </td>
              <td style="padding:15px">
                <span style="background-color:#66BAB7;color:#fff;padding:5px;font-size:12px">發問人數:6</span>
              </td>
              <td style="padding:15px">
                <h5><span style="font-weight:bold;">[Solved]</span>2018-09-21請問這題這樣寫對嗎?</h5>
                <h5><span style="font-weight:bold;">[Unsolved]</span>2018-09-21請問這題這樣寫對嗎?</h5>
              </td>
          </tr>
        </tbody>
      </table>
    </center>

  </div>
  <div class="col-sm-2">

  </div>


</div>

@endsection