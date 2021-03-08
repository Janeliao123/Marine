<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Chapter;
use App\Section;
use App\Question;
use App\Record;
use App\UserCollection;
use Auth;
use File;

class UserPageController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $chapter = Chapter::all();
        $section = Section::all();
        $pic_name = array();
        $stu_level = Record::where([
                'user_id' => $user_id,
                'status' =>'AC'
              ])->get()->groupBy('question_id')->count();
        foreach ($chapter as $key_1 => $value_1) {
          $count = 0; //記該章完成了幾小節
          foreach ($section as $key_2 => $value_2) {
            if($value_2->chapter_id == $value_1->id){
              $t = explode("、",$value_2->title);
              ${'c_all_' . $value_2->id} =  Question::where('section_id', $value_2->id)->count(); //該節總題數
              ${'c_stu_' . $value_2->id} = Record::where([
                'user_id' => $user_id,
                'section_id' => $value_2->id,
                'status' =>'AC'
              ])->get()->groupBy('question_id','status','user_id')->count(); //學生做這節作對的題目數
              if ( 0.8*${'c_all_' . $value_2->id} < 1) {   // $a->那節題數*0.8後取整數的值
                $a = 1;
              }else {
                $a = floor( 0.8*${'c_all_' . $value_2->id} );
              }
              if( ${'c_stu_' . $value_2->id} >= $a){  //作對的題目達8成則地圖變色
                      /*
                        bw.png => black and white黑白圖片
                        half.png => 半黑半彩色
                        done.png => 彩色圖片
                      */
                      if(${'c_all_' . $value_2->id} == 0){
                          $pic_name[$value_2->id] = $t[0].'bw.png';
                      }else {
                          $pic_name[$value_2->id] = $t[0].'half.png';
                          $count = $count + 1;
                      }

              }else{
                  $pic_name[$value_2->id] = $t[0].'bw.png';
              }
            }
          }
          $count_s = Section::where('chapter_id',$value_1->id)->count(); //記該章有幾小節
          if($count >= $count_s){ //若完成該章所有小節則圖片全亮
            foreach ($section as $key_3 => $value_3) {
              if($value_3->chapter_id == $value_1->id){
                  $tt = explode("、",$value_3->title);
                  $pic_name[$value_3->id] = $tt[0].'done.png';
              }
            }
          }
        }
        return view('user_page',compact('pic_name','chapter','section','stu_level'));
    }

    public function show()
    {
      $u_id = Auth::user()->id;
      $q_id = UserCollection::where('user_id',$u_id)->pluck('question_id');
      $questions = Question::whereIn('id',$q_id)->get();
      $stu_level = Record::where([
                'user_id' => $u_id,
                'status' =>'AC'
              ])->get()->groupBy('question_id','status','user_id')->count();
      $codes = Record::where([
        'user_id' => $u_id,
      ])->orderBy('created_at', 'desc')->get();
      $questions_title = Question::all()->pluck('title');
      for($i=0;$i<$codes->count();$i++){
        $codes[$i]->code = nl2br(htmlspecialchars(File::get(storage_path("app/".$u_id."/".$codes[$i]->location))));
      }
      // return $questions_title;
      // dd($questions_title);
      return view('personal_discussion',compact('questions','stu_level','codes','questions_title'));
    }
    public function showCode()
    {
      $u_id = Auth::user()->id;
      return $u_id;
    }
}
