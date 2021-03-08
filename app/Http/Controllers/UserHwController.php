<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Course_user_list;
use App\Course_list;
use App\Admin_select_question;
use App\Question;
use App\Section;
use App\Chapter;
use App\Record;
use App\Homework;
use Auth;
use File;


class UserHwController extends Controller
{
    public function index(){
    	$acct = Auth::user()->acct;
    	$u_id = Auth::user()->id;
		$class_id = Course_user_list::where('acct',$acct)->pluck('course_list_id');
		foreach($class_id as $key => $value){
			$school[$key] = Course_list::where('id',$value)->pluck('school_year','id');
			$qid[$key] = Admin_select_question::where('course_list_id',$value)->orderBy('question_id','asc')->pluck('question_id');
      $due[$key] = Admin_select_question::where('course_list_id',$value)->orderBy('question_id','asc')->select('due_date','question_id')->get();
			$sid[$key] = Question::whereIn('id',$qid[$key])->pluck('section_id');
			$cid[$key] = Section::whereIn('id',$sid[$key])->pluck('chapter_id');
			$questions[$key] = Question::whereIn('id',$qid[$key])->get();
			$sections[$key] = Section::whereIn('id',$sid[$key])->get();
			$chapters[$key] = Chapter::whereIn('id',$cid[$key])->get();

		}
		//dd($school);
		if(!empty($school)&&!empty($qid)){
            return view('user_hw',compact('chapters','sections','questions','class_id','school','qid','due','sid','cid','school_id'));
        }else{
			return view('user_hw_null');
		}
	}

	public function coderec($cid,$id){
    	$u_id = Auth::user()->id;
		$loc[$id] = Record::where(['user_id'=>$u_id,'question_id'=>$id])->orderBy('created_at','des')->pluck('location');
		$sta[$id] = Record::where(['user_id'=>$u_id,'question_id'=>$id])->orderBy('created_at','des')->pluck('status');
		$t[$id] = Record::where(['user_id'=>$u_id,'question_id'=>$id])->orderBy('created_at','des')->pluck('created_at');
		$code_id[$id] = Record::where(['user_id'=>$u_id,'question_id'=>$id])->orderBy('created_at','des')->pluck('id');

		$select_question = Admin_select_question::where(['question_id'=>$id,'course_list_id'=>$cid])->first();
		$select_question_id = $select_question->id;
		$handin_hw=Homework::where(['user_id'=>$u_id,'select_questions_id'=>$select_question_id])->first();
    $due_date = $select_question->due_date;
		for($j=0;$j<count($loc[$id]);$j++){
			$code[$id][$j] = nl2br(htmlspecialchars(File::get(storage_path("app/".$u_id."/".$loc[$id][$j]))));
			$status[$id][$j] = $sta[$id][$j];
			$time[$id][$j] = $t[$id][$j];
			$codei[$id][$j]= $code_id[$id][$j];
		}
		//dd($handin_hw);
		return view('coderec',compact('id','code','status','time','codei','cid','handin_hw','due_date'));

	}

	//$cid = course_id;$id = question_id
	public function hand_in($cid,$id,$code_id){
		$select_question = Admin_select_question::where(['question_id'=>$id,'course_list_id'=>$cid])->first();
		if(date("Y-m-d H:i:s")<$select_question->due_date || $select_question->due_date==null){
      $code_record = Record::find($code_id);
      $code_text = File::get(storage_path("app/".$code_record->user_id."/".$code_record->location));

      $handin_hw=Homework::where(['user_id'=>Auth::user()->id,'select_questions_id'=>$select_question->id])->first();
      if($handin_hw){
        Storage::delete("hw/".$select_question->id."/".Auth::user()->acct.".cpp");
        $handin_hw->delete();
      }

      //dd($handin_hw);

      Storage::put(("hw/".$select_question->id."/".Auth::user()->acct.".cpp"), $code_text);
      //dd($code_text);
      $new_homework = new Homework;
      $new_homework->user_id = Auth::user()->id;
      $new_homework->location = Auth::user()->acct;
      $new_homework->select_questions_id = $select_question->id;
      $new_homework->code_id = $code_id;
      $new_homework->save();


      return redirect('userhw');
    }else {
      return back();
    }

	}

	public function deleteHW($id){
		$hw_to_be_delete = Homework::find($id);
		if(Auth::user()->id==$hw_to_be_delete->user_id){
			Storage::delete("hw/".$hw_to_be_delete->select_questions_id."/".Auth::user()->acct.".cpp");
			$hw_to_be_delete->delete();
		}
		return redirect('userhw');
	}
}
