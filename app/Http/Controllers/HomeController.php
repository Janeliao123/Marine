<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NewReport;
use App\Section;
use App\Chapter;
use App\Question;
use App\Course_user_list;
use Auth;
use DB;
class Question_cal {
    public $q_id;
    public $count;
    public $title;
    public $difficulty;
}
class HomeController extends Controller
{


    public function index()
    {
        $news = NewReport::where('course_list_id','0')->orderBy('id','desc')
        ->take(10)
        ->get();
        $chapter = Chapter::all();
        $section = Section::all();
        if(Auth::check()){
          $user_id = Auth::user()->acct;
          $course_id = Course_user_list::where('acct',$user_id)->pluck('course_list_id');
          $class_news = NewReport::whereIn('course_list_id',$course_id)->orderBy('id','desc')->get();
          return view('index',[
            'allnews'=>$news,
            'chapter'=>$chapter,
            'section'=>$section,
            'class_news'=>$class_news,
          ]);
        }elseif (!Auth::guard('admin')->guest()) {
          $admin_id = Auth::guard('admin')->user()->id;
          $class_news = NewReport::where('admin_id',$admin_id)->orderBy('id','desc')->get();
          return view('index',[
            'allnews'=>$news,
            'chapter'=>$chapter,
            'section'=>$section,
            'class_news'=>$class_news,
          ]);
        }
        else {
          return view('index',[
            'allnews'=>$news,
            'chapter'=>$chapter,
            'section'=>$section
          ]);
        }

    }
    public function cal(){

      $hot = DB::table('questions')
                ->where('correct_rate','!=',0)
                ->orderBy('count', 'desc')
                ->take(10)->get();
      $hard = DB::table('questions')
                ->where('correct_rate','!=',0)
                ->orderBy('correct_rate')
                ->take(10)->get();
      $avg = DB::table('questions')->where('correct_rate','!=','0')->avg('correct_rate');
      $avg = round($avg*100,0);

      $count_e = DB::table('questions')
                ->where('difficulty', 1)
                ->sum('count');
      $count_m = DB::table('questions')
                ->where('difficulty', 2)
                ->sum('count');
      $count_h = DB::table('questions')
                ->where('difficulty', 3)
                ->sum('count');

      return view('cal.cal',compact('hot','c_hot','hard','c_hard','avg','count_e','count_m','count_h'));




    }

      public function old(){
        $question = Record::with('question')->get()->groupBy('question_id');
        /*熱門題目*/
        $count = $question->count();
        if($count == 0){

          return view('cal.cal',compact('avg','count_e','count_m','count_h'));
        }else{
          foreach ($question as $key => $value) {
            $hot[$key-1] = new Question_cal();
            $count = Record::where('question_id',$value[0]->question_id)->count();
            $hot[$key-1]->q_id = $value[0]->question_id;
            $hot[$key-1]->count = $count;
            $hot[$key-1]->title = $value[0]->question->title;
            if($value[0]->question->difficulty == 1){
              $hot[$key-1]->difficulty = '易';
            }elseif($value[0]->question->difficulty == 2){
              $hot[$key-1]->difficulty = '中';
            }else{
              $hot[$key-1]->difficulty = '難';
            }
          }
          if(isset($hot)){
            $hot = collect($hot);
            $hot = $hot->sortByDesc('count');// sort $hot
            $c_hot = count($hot);
          }


          /*最多人做錯的題目*/
          foreach ($question as $keys => $values) {
            $counts = Record::where('question_id',$values[0]->question_id)->where('status','!=','AC')->count();
            if($counts == 0){
            }else{  //有人做錯過才算
                $hard[$keys-1] = new Question_cal();
                $hard[$keys-1]->count = $counts;
                $hard[$keys-1]->q_id = $values[0]->question_id;
                $hard[$keys-1]->title = $values[0]->question->title;
                if($values[0]->question->difficulty == 1){
                  $hard[$keys-1]->difficulty = '易';
                }elseif($values[0]->question->difficulty == 2){
                  $hard[$keys-1]->difficulty = '中';
                }else{
                  $hard[$keys-1]->difficulty = '難';
                }
            }
          }
          if(isset($hard)){
            $hard = collect($hard);
            $hard = $hard->sortByDesc('count'); // sort difficulty
            $c_hard = count($hard);
          }

          //答對率
          $avg = 0;
          $all = Record::all()->count();
          $correct = Record::where('status','AC')->count();

          if($all == 0){
            $avg = 0;
          }else{
            $avg = round( ($correct / $all),2 )*100 . "%";
          }
          //難易度比
          $le_record = Record::with('question')->get()->groupBy('user_id','question_id');
          $c_le = count($le_record);
          // dd($le_record[1]);
          foreach ($le_record[1] as $key_l => $value_l) {
            if($value_l->question->difficulty == 1){
              $count_e = $count_e + 1;
            }elseif ($value_l->question->difficulty == 2) {
              $count_m = $count_m + 1;
            }else {
              $count_h = $count_h + 1;
            }
          }

          return view('cal.cal',compact('hot','c_hot','hard','c_hard','avg','count_e','count_m','count_h'));
          }
      }


}
