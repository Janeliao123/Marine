<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Course_list;
use App\Course_user_list;
use App\Admin_select_question;
use App\Chapter;
use App\Section;
use App\Homework;
use App\Question;
use App\User;
use DB;
use Auth;
class no_ans {
    public $name;
    public $acct;
}
class AdminSelectQuestionsController extends Controller
{
  public function index()
  {
      $admin_id = Auth::guard('admin')->user()->id;
      $courses = Course_list::where('admin_id',$admin_id)->get();
      return view('admin/admin_select_question.index',compact('courses'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function select($id)
  {
      $admin_id = Auth::guard('admin')->user()->id;
      $chapter = Chapter::all();
      $section = Section::all();
      $question = Question::where('admin_id',$admin_id)->orWhere('is_public',1)->get();
      $selected_q = Course_list::find($id)->question;
      return view('admin/admin_select_question.create',compact('question','chapter','section','selected_q','id'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $c_id = $request->course_list_id;
    $questions = $request->input('q_id');
    if($questions==null){

    }else {
      foreach ($questions as $key => $value) {
        $q = new Admin_select_question;
        $q->course_list_id = $c_id;
        $q->question_id = $value;
        $q->save();
      }
    }

    return redirect('admin/select_question/'.$c_id);

  }

  /**
   * Display the specified resource.
*
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      // $questions = Course_list::find($id)->question;
      // dd($questions);
      $questions = DB::table('admin_select_questions')
              ->where('course_list_id',$id)
              ->join('questions', 'admin_select_questions.question_id', '=', 'questions.id')
              ->select('questions.title', 'questions.id','questions.section_id','admin_select_questions.due_date','admin_select_questions.id as aid')
              ->get();

      $course = Course_list::find($id);
      $year = $course->school_year;
      $chapter = Chapter::all();
      $section = Section::all();
      return view('admin/admin_select_question.show',compact('questions','year','chapter','section','id'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {

  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    Admin_select_question::find($id)->delete();
    return back();
  }
  public function showHomework($id,$qid){
    $course_select_question = Admin_select_question::where(['question_id'=>$qid,'course_list_id'=>$id])->first();
    $question_name = Question::find($course_select_question->question_id)->title;
    //dd($question_name);
    $csqid = $course_select_question->id;
    $clsid = $course_select_question->course_list_id;
    // $homeworks = Homework::where(['select_questions_id'=>$csqid])->get();

    //提交的學生
    $homeworks = DB::table('homeworks')
            ->where('select_questions_id',$csqid)
            ->join('users', 'homeworks.user_id', '=', 'users.id')
            ->select('users.acct', 'users.name', 'homeworks.user_id','homeworks.location','homeworks.code_id','homeworks.select_questions_id')
            ->get();
    $students = DB::table('course_user_lists')
            ->where('course_list_id',$clsid)
            ->join('users', 'course_user_lists.acct', '=', 'users.acct')
            ->select('users.acct', 'users.name', 'users.id')
            ->get();
    // dd($students);
    //未提交的學生
    foreach ($students as $key => $value) {
      $flag = Homework::where('select_questions_id',$csqid)->where('user_id',$value->id)->first();
      if ($flag==null) {
        $no_ans[$key] = new no_ans();
        $no_ans[$key]->acct = $value->acct;
        $no_ans[$key]->name = $value->name;
      }
    }
    //未註冊的學生
    $users = Course_user_list::where('course_list_id',$clsid)->get();
    foreach ($users as $keys => $values) {
      $this_user = User::where('acct',$values->acct)->first(); //找學號
      if($this_user == null){   //表示此人尚未註冊...
        $no_register[$keys] = new no_ans();
        $no_register[$keys]->acct = $values->acct;
        $no_register[$keys]->name = $values->name;
      }
    }
    return view('admin/admin_select_question.homework',compact('course_select_question','homeworks','no_ans','no_register','question_name'));
  }
  public function downloadHomework($id){
	  //return ("zip -0 -r ../storage/app/hw/".$id."/".$id.".zip ".$id."/*.cpp");
	exec("ln -s /var/www/html/marine/storage/app/hw/".$id." ".$id);
	exec("zip -0 -r ../storage/app/hw/".$id."/".$id.".zip ".$id."/*.cpp");
	exec("rm ".$id);
    return response()->download(storage_path("app/hw/".$id."/".$id.".zip"));
  }
  public function due_date(Request $request){
    $ad_q=Admin_select_question::find($request->ad_id);
    $ad_q->due_date=$request->due_date;
    $ad_q->save();
    return back();
  }
}
