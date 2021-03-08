<?php

namespace App\Http\Controllers;

use App\Compiler;
use App\Question;
use App\Chapter;
use App\Section;
use App\Course_user_list;
use App\Course_list;
use App\Admin;
use Auth;
use App\Record;
use App\UserCollection;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class CompilerController extends Controller 
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(Auth::check()){
            return view('compiler.index');   
        }else{
            return view('auth.login');
        }    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function testCode(Request $request){
        $u_id = Auth::user()->id;
        $code = $request->code;
        $input = $request->test_input;
        Storage::put(($u_id.'/input.in'), $input);
        Storage::put(($u_id.'/Helloworld.c'), $code);

        $name="aa".rand(1,10000000);

        exec("sudo ../storage/compiler/shell_compile ".$name." ".$u_id );
        $executionStartTime = microtime(true);
        exec("sudo ../storage/compiler/shell_exec ".$name." ".$u_id );
        $mem=exec("grep Maximum ../storage/app/".$u_id."/run_err");
        $content=File::get(storage_path("app/".$u_id."/output"));
        $err_content = File::get(storage_path("app/".$u_id."/com_err"));

        $return_value="";
        if($err_content )
            $return_value = nl2br("Complier Error<br>".$err_content);
        else if(!$content)
            $return_value = nl2br("Run Error or No Print or Run over 10 seconds\n");
        else{
            $return_value = nl2br($content);
            $executionEndTime = microtime(true);
            $seconds = $executionEndTime - $executionStartTime;
            $seconds = sprintf('%0.2f', $seconds);
            $return_value .= nl2br("\nCompiled And Executed In:". $seconds."s\nMemory size:".$mem."\n");
            // if($seconds>5)
            //     $return_value =  nl2br("\nTLE\n你使用了過多的時間或是輸出\n");
        }
        File::delete(storage_path("app/".$u_id."/output"),storage_path("app/".$u_id."/Helloworld.c"),storage_path("app/".$u_id."/input.in"),storage_path("app/".$u_id."/run_err"),storage_path("app/".$u_id."/com_err"));
        exec("sudo docker rm -f ".$name);
        return $return_value;
        /*把時間跟output分開 有需要以後再做
        return response()->json([
            'return_value' => $return_value,
            'state' => 'CA'
        ]);*/
    }

    public function judgeCode(Request $request){
        $u_id = Auth::user()->id;
        $code = $request->code;
        $ans_problem = Question::find($request->question_id);
        $input = $ans_problem->input_admin;
        Storage::put(($u_id.'/input.in'), $input);
        Storage::put(($u_id.'/Helloworld.c'), $code);

        $name="aa".rand(1,10000000);
        exec("sudo ../storage/compiler/shell_compile ".$name." ".$u_id );
        $executionStartTime = microtime(true);
        exec("sudo ../storage/compiler/shell_exec ".$name." ".$u_id );

        $err_content = File::get(storage_path("app/".$u_id."/com_err"));
        $output_admin = $ans_problem->output_admin;
        Storage::put(($u_id.'/ou'), $output_admin);

        $content=File::get(storage_path("app/".$u_id."/output"));
        //substr($content, 0, -1);
        $sample_output = File::get(storage_path('app/'.$u_id.'/ou'));

        $return_value = "";
        
		if($err_content )
            $return_value = "CE";
        else if(!$content)
            $return_value = "RE";
        else{
            $i=0;
            $j=0;
            $com="";			
            //$content = (trim($content, "\x00..\x1F"));
			$content = mb_convert_encoding($content,"utf-8","auto");
			$sample_output = str_replace(array( "\n\r","\r\n","\r", "\n" ), '\n', $sample_output);
			//$sample_output =(trim($sample_output, "\x00..\x1F"));
			$sample_output = mb_convert_encoding($sample_output,"utf-8","auto");
			$content = str_replace(array("\r", "\n", "\r\n", "\n\r"), '\n', $content);			        
            

            if(($content) == ($sample_output))
                $return_value =  "AC";
            else
                $return_value =  "WA";

            // $executionEndTime = microtime(true);
            // $seconds = $executionEndTime - $executionStartTime;
            // $seconds = sprintf('%0.2f', $seconds);
            //$return_value .= nl2br("\nCompiled And Executed In:". $seconds."s\nMemory size:".$mem."\n");
            //if($seconds>1)
                //$return_value =  nl2br("\nTLE\n你使用了過多的時間或是輸出\n");

        }
        File::delete(storage_path("app/".$u_id."/output"),storage_path("app/".$u_id."/Helloworld.c"),storage_path("app/".$u_id."/input.in"),storage_path("app/".$u_id."/run_err"),storage_path("app/".$u_id."/com_err"),storage_path("app/".$u_id."/run_err"),storage_path("app/".$u_id."/ou"));
        exec("sudo docker rm -f ".$name);
        $rec_loc="loc".rand(1,10000000);
        Storage::put(($request->user_id."/".$rec_loc), $code);
        exec("sudo mkdir -p ../storage/app/".$request->user_id." && sudo cp ../storage/app/Helloworld.c ../storage/app/".$request->user_id."/".$rec_loc);
        $s_id = $ans_problem->section_id;

        $record = new Record;
        $record->user_id = $request->user_id;
        $record->question_id = $request->question_id;
        $record->section_id = $s_id;
        $record->status = $return_value;
        $record->location = $rec_loc;
        $record->save(); 		
	
	    //答題人數&答對率
	    $qid = $request->question_id; 
        $question = Question::find($qid);
        $old_count = Question::where('id',$qid)->pluck('count');
        $new_count = $old_count[0]+1;
        $question->count = $new_count;
        $c_rate = Question::where('id',$qid)->pluck('correct_rate');
        $old_c_rate = $c_rate[0];
        $old_correct = $old_count[0]*$old_c_rate;
        if($return_value=="AC"){
            $new_correct = $old_correct+1;
            $new_c_rate = $new_correct/$new_count;
        }else{
            $new_c_rate = $old_correct/$new_count;
        }
        $question->correct_rate = $new_c_rate;
	    $question->save();	
        //適性化判斷
        $qid = $request->question_id;
        $csid = Question::where('id',$qid)->pluck('section_id');
        $uid = Auth::user()->id;
        $acct = Auth::user()->acct;
        $course_list_id = Course_user_list::where('acct',$acct)->pluck('course_list_id')->last();
        $arr_clid = json_decode(json_encode($course_list_id), true);
        if(!empty($arr_clid)){
            $admin_id = Course_list::where('id',$course_list_id)->pluck('admin_id');
            // $admin_name = Admin::where('id',$admin_id)->pluck('name');
        }    
        $qstatus = Record::where(['question_id' => $qid , 'user_id' => $uid])->pluck('status')->last();
        $ac_qid = Record::where([
            'user_id' => $uid,
            'status' => 'AC',
            ])->groupBy('question_id')->pluck('question_id');
        $ac_sid = Question::whereIn('id',$ac_qid)->pluck('section_id');
        $ac_dif = Question::whereIn('id',$ac_qid)->pluck('difficulty');
        $csid_ac_qid = Question::whereIn('id',$ac_qid)->where('section_id',$csid)->pluck('id');
        $arr_ac_qid = json_decode(json_encode($ac_qid), true);
        $arr_csid_ac_qid = json_decode(json_encode($csid_ac_qid), true);
        $all_sum=0;
        $all_avg=0;
        $csid_sum=0;
        $csid_avg=0;
        $sid_key=0;
        $end_sum=0;
        if(!empty($arr_ac_qid)){
            foreach($ac_dif as $dif_key => $acdif){
                $all_sum += $acdif;
            }
            $all_avg = $all_sum/($dif_key+1);
            if(!empty($arr_csid_ac_qid)){
                foreach($ac_sid as $key => $acsid){
                    if($acsid==$csid[0]){
                        $csid_sum += $ac_dif[$key];
                        $sid_key++;
                    }
                }
                $csid_avg = $csid_sum/($sid_key);
                $end_sum = $all_avg*0.3+$csid_avg*0.7;
            }else{
                $end_sum = $all_avg;
            }
        }else{
            $end_sum = 0;
        }
	    global $rec_dif;
        $rec_sid=$csid[0];
        $jump_sid=0; //false
        function recdif($a){
            $end_sum = $a;
            global $rec_dif;
            if($end_sum<=1.5){
                $rec_dif=1;
            }elseif($end_sum>1.5 && $end_sum<=2.5){
                $rec_dif=2;
            }elseif($end_sum>2.5){
                $rec_dif=3;
            }
        }
        recdif($end_sum);
        if($qstatus=="AC"){
            if(!empty($arr_clid)){
                $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$rec_dif,'is_public'=>'1'])->whereNotIn('id',$ac_qid)->orWhere(function($query)use($admin_id,$rec_sid,$rec_dif){
                    $query->where('admin_id','=',$admin_id)
                    ->where('is_public','0')
                    ->where('section_id',$rec_sid)
                    ->where('difficulty',$rec_dif);
                })->pluck('id');
            }else{
                $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$rec_dif,'is_public'=>'1'])->whereNotIn('id',$ac_qid)->pluck('id');
            }            
            $arr_rec_qid = json_decode(json_encode($rec_qid), true);
            $tmp_rec_dif = $rec_dif;
            while(empty($arr_rec_qid)){
                $tmp_rec_dif++;
                if($tmp_rec_dif==4){
                    $jump_sid=1;
                    break;
                }
                if(!empty($arr_clid)){
                    $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$tmp_rec_dif,'is_public'=>'1'])->whereNotIn('id',$ac_qid)->orWhere(function($query)use($admin_id,$rec_sid,$tmp_rec_dif){
                        $query->where('admin_id',$admin_id)
                              ->where('is_public','0')
                              ->where('section_id',$rec_sid)
                              ->where('difficulty',$tmp_rec_dif);
                    })->pluck('id');
                    // $ttt = Question::whereIn('id',$rec_qid)->pluck('difficulty');
                }else{
                    $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$tmp_rec_dif,'is_public'=>'1'])->whereNotIn('id',$ac_qid)->pluck('id');
                } 
                $arr_rec_qid = json_decode(json_encode($rec_qid), true);
            }
            while($jump_sid==1){
                $end_sum=$all_avg;
                recdif($end_sum);
                $rec_sid++;
                if(!empty($arr_clid)){
                    $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$rec_dif,'is_public'=>'1'])->whereNotIn('id',$ac_qid)->orWhere(function($query)use($admin_id,$rec_sid,$rec_dif){
                        $query->where('admin_id',$admin_id)
                              ->where('is_public','0')
                              ->where('section_id',$rec_sid)
                              ->where('difficulty',$rec_dif);
                    })->pluck('id');
                }else{
                    $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$rec_dif,'is_public'=>'1'])->whereNotIn('id',$ac_qid)->pluck('id');
                } 
                $arr_rec_qid = json_decode(json_encode($rec_qid), true);
                $j_tmp_rec_dif=$rec_dif;
                while(empty($arr_rec_qid)){
                    $j_tmp_rec_dif++;
                    if($j_tmp_rec_dif==4){
                        $jump_sid=1;
                        break;
                    }
                    if(!empty($arr_clid)){
                        $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$j_tmp_rec_dif,'is_public'=>'1'])->whereNotIn('id',$ac_qid)->orWhere(function($query)use($admin_id,$rec_sid,$j_tmp_rec_dif){
                            $query->where('admin_id',$admin_id)
                                  ->where('is_public','0')
                                  ->where('section_id',$rec_sid)
                                  ->where('difficulty',$j_tmp_rec_dif);
                        })->pluck('id');
                    }else{
                        $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$j_tmp_rec_dif,'is_public'=>'1'])->whereNotIn('id',$ac_qid)->pluck('id');
                    }
                    $arr_rec_qid = json_decode(json_encode($rec_qid), true);
                }
                if(!empty($arr_rec_qid)) break;
            }
        }else{
            $tmp_end_sum = $end_sum-1;
            recdif($tmp_end_sum);
            if(!empty($arr_clid)){
                $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$rec_dif,'is_public'=>'1'])->orWhere(function($query)use($admin_id,$rec_sid,$rec_dif){
                    $query->where('admin_id',$admin_id)
                          ->where('is_public','0')
                          ->where('section_id',$rec_sid)
                          ->where('difficulty',$rec_dif);
                })->pluck('id');
            }else{
                $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$rec_dif,'is_public'=>'1'])->pluck('id');
            }
            $arr_rec_qid = json_decode(json_encode($rec_qid), true);
            $tmp_rec_dif = $rec_dif;
            while(empty($arr_rec_qid)){
                $tmp_rec_dif--;
                if($tmp_rec_dif==0){
                    $jump_sid=1;
                    break;
                } 
                if(!empty($arr_clid)){
                    $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$tmp_rec_dif,'is_public'=>'1'])->orWhere(function($query)use($admin_id,$rec_sid,$tmp_rec_dif){
                        $query->where('admin_id',$admin_id)
                              ->where('is_public','0')
                              ->where('section_id',$rec_sid)
                              ->where('difficulty',$tmp_rec_dif);
                    })->pluck('id');
                }else{
                    $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$tmp_rec_dif,'is_public'=>'1'])->pluck('id');
                } 
                $arr_rec_qid = json_decode(json_encode($rec_qid), true);
            }
            while($jump_sid==1){
                $end_sum=$all_avg;
                recdif($end_sum);
                $rec_sid--;
                if(!empty($arr_clid)){
                    $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$rec_dif,'is_public'=>'1'])->orWhere(function($query)use($admin_id,$rec_sid,$rec_dif){
                        $query->where('admin_id',$admin_id)
                              ->where('is_public','0')
                              ->where('section_id',$rec_sid)
                              ->where('difficulty',$rec_dif);
                    })->pluck('id');
                }else{
                    $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$rec_dif,'is_public'=>'1'])->pluck('id');
                }
                $arr_rec_qid = json_decode(json_encode($rec_qid), true);
                $j_tmp_rec_dif=$rec_dif;
                while(empty($arr_rec_qid)){
                    $j_tmp_rec_dif++;
                    if($j_tmp_rec_dif==4){
                        $jump_sid=1;
                        break;
                    } 
                    if(!empty($arr_clid)){
                        $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$j_tmp_rec_dif,'is_public'=>'1'])->orWhere(function($query)use($admin_id,$rec_sid,$j_tmp_rec_dif){
                            $query->where('admin_id',$admin_id)
                                  ->where('is_public','0')
                                  ->where('section_id',$rec_sid)
                                  ->where('difficulty',$j_tmp_rec_dif);
                        })->pluck('id');
                    }else{
                        $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$j_tmp_rec_dif,'is_public'=>'1'])->pluck('id');
                    }
                    $arr_rec_qid = json_decode(json_encode($rec_qid), true);
                }
                if(!empty($arr_rec_qid)) break;
            }
        }
        $recqid_key = array_rand($arr_rec_qid,1);
        $end_rec_qid = $arr_rec_qid[$recqid_key];     
        $recqid_detail = Question::find($end_rec_qid);
        $recqid_adminid = Question::where('id',$end_rec_qid)->pluck('admin_id');
        $recqid_adminname = Admin::where('id',$recqid_adminid)->pluck('name')->last();
        return response()->json([
            'returnva' =>$return_value,
            'sam'=>$sample_output,
            'out'=>$content,            
            'recqid'=>$end_rec_qid,
            'qstatus'=>$qstatus,
            'recqid_detail'=>$recqid_detail,
            'recqid_adminname'=>$recqid_adminname,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Compiler  $compiler
     * @return \Illuminate\Http\Response
     */
    public function show(Compiler $compiler,$qid)
    {
        $question = Question::find($qid);
        $user = Auth::user();
        //珍藏題目判斷
        $isStarred = (bool) UserCollection::where('user_id', Auth::id())
                            ->where('question_id', $qid)
                            ->first();
        //取得此章節所有題目
        $csid = Question::where('id',$qid)->pluck('section_id');
        $ccid = Section::where('id',$csid)->pluck('chapter_id');
        $allc = Chapter::where('id',$ccid)->pluck('title');
        $allsid = Section::where('chapter_id',$ccid)->pluck('id');
        $alls = Section::whereIn('id',$allsid)->get();
        $allq = Question::whereIn('section_id',$allsid)->get();
        $sec_title = Section::where('id',$csid)->pluck('title');

        return response()->json([
            'question' => $question,
            'user' => $user,
            'input'=>nl2br($question->input_student),
            'output'=>nl2br($question->output_student),
            'isStarred' => $isStarred,
            'ccid' => $ccid,
            'chapters' => $allc[0],
            'sections' => $alls,
            'questions' => $allq,
            'sec_title'=>$sec_title[0],
        ]);

    }

    public function starred($qid)
    {
        Auth::user()->starred()->attach($qid);
        return back();
    }

    public function unstarred($qid){
        Auth::user()->starred()->detach($qid);
        return back();
    }

    public function recommend($qid){
        $csid = Question::where('id',$qid)->pluck('section_id');
        $uid = Auth::user()->id;
        $acct = Auth::user()->acct;
        $course_list_id = Course_user_list::where('acct',$acct)->pluck('course_list_id')->last();
        $arr_clid = json_decode(json_encode($course_list_id), true);
        if(!empty($arr_clid)){
            $admin_id = Course_list::where('id',$course_list_id)->pluck('admin_id');
            // $admin_name = Admin::where('id',$admin_id)->pluck('name');
        }    
        $qstatus = Record::where(['question_id' => $qid , 'user_id' => $uid])->pluck('status')->last();
        $ac_qid = Record::where([
            'user_id' => $uid,
            'status' => 'AC',
            ])->groupBy('question_id')->pluck('question_id');
        $ac_sid = Question::whereIn('id',$ac_qid)->pluck('section_id');
        $ac_dif = Question::whereIn('id',$ac_qid)->pluck('difficulty');
        $csid_ac_qid = Question::whereIn('id',$ac_qid)->where('section_id',$csid)->pluck('id');
        $arr_ac_qid = json_decode(json_encode($ac_qid), true);
        $arr_csid_ac_qid = json_decode(json_encode($csid_ac_qid), true);
        $all_sum=0;
        $all_avg=0;
        $csid_sum=0;
        $csid_avg=0;
        $sid_key=0;
        $end_sum=0;
        if(!empty($arr_ac_qid)){
            foreach($ac_dif as $dif_key => $acdif){
                $all_sum += $acdif;
            }
            $all_avg = $all_sum/($dif_key+1);
            if(!empty($arr_csid_ac_qid)){
                foreach($ac_sid as $key => $acsid){
                    if($acsid==$csid[0]){
                        $csid_sum += $ac_dif[$key];
                        $sid_key++;
                    }
                }
                $csid_avg = $csid_sum/($sid_key);
                $end_sum = $all_avg*0.3+$csid_avg*0.7;
            }else{
                $end_sum = $all_avg;
            }
        }else{
            $end_sum = 0;
        }
        global $rec_dif;
        $rec_sid=$csid[0];
        $jump_sid=0; //false
        function recdif($a){
            $end_sum = $a;
            global $rec_dif;
            if($end_sum<=1.5){
                $rec_dif=1;
            }elseif($end_sum>1.5 && $end_sum<=2.5){
                $rec_dif=2;
            }elseif($end_sum>2.5){
                $rec_dif=3;
            }
        }
        recdif($end_sum);
        if($qstatus=="AC"){
            if(!empty($arr_clid)){
                $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$rec_dif,'is_public'=>'1'])->whereNotIn('id',$ac_qid)->orWhere(function($query)use($admin_id,$rec_sid,$rec_dif){
                    $query->where('admin_id','=',$admin_id)
                    ->where('is_public','0')
                    ->where('section_id',$rec_sid)
                    ->where('difficulty',$rec_dif);
                })->pluck('id');
            }else{
                $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$rec_dif,'is_public'=>'1'])->whereNotIn('id',$ac_qid)->pluck('id');
            }            
            $arr_rec_qid = json_decode(json_encode($rec_qid), true);
            $tmp_rec_dif = $rec_dif;
            while(empty($arr_rec_qid)){
                $tmp_rec_dif++;
                if($tmp_rec_dif==4){
                    $jump_sid=1;
                    break;
                }
                if(!empty($arr_clid)){
                    $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$tmp_rec_dif,'is_public'=>'1'])->whereNotIn('id',$ac_qid)->orWhere(function($query)use($admin_id,$rec_sid,$tmp_rec_dif){
                        $query->where('admin_id',$admin_id)
                              ->where('is_public','0')
                              ->where('section_id',$rec_sid)
                              ->where('difficulty',$tmp_rec_dif);
                    })->pluck('id');
                    // $ttt = Question::whereIn('id',$rec_qid)->pluck('difficulty');
                }else{
                    $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$tmp_rec_dif,'is_public'=>'1'])->whereNotIn('id',$ac_qid)->pluck('id');
                } 
                $arr_rec_qid = json_decode(json_encode($rec_qid), true);
            }
            while($jump_sid==1){
                $end_sum=$all_avg;
                recdif($end_sum);
                $rec_sid++;
                if(!empty($arr_clid)){
                    $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$rec_dif,'is_public'=>'1'])->whereNotIn('id',$ac_qid)->orWhere(function($query)use($admin_id,$rec_sid,$rec_dif){
                        $query->where('admin_id',$admin_id)
                              ->where('is_public','0')
                              ->where('section_id',$rec_sid)
                              ->where('difficulty',$rec_dif);
                    })->pluck('id');
                }else{
                    $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$rec_dif,'is_public'=>'1'])->whereNotIn('id',$ac_qid)->pluck('id');
                } 
                $arr_rec_qid = json_decode(json_encode($rec_qid), true);
                $j_tmp_rec_dif=$rec_dif;
                while(empty($arr_rec_qid)){
                    $j_tmp_rec_dif++;
                    if($j_tmp_rec_dif==4){
                        $jump_sid=1;
                        break;
                    }
                    if(!empty($arr_clid)){
                        $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$j_tmp_rec_dif,'is_public'=>'1'])->whereNotIn('id',$ac_qid)->orWhere(function($query)use($admin_id,$rec_sid,$j_tmp_rec_dif){
                            $query->where('admin_id',$admin_id)
                                  ->where('is_public','0')
                                  ->where('section_id',$rec_sid)
                                  ->where('difficulty',$j_tmp_rec_dif);
                        })->pluck('id');
                    }else{
                        $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$j_tmp_rec_dif,'is_public'=>'1'])->whereNotIn('id',$ac_qid)->pluck('id');
                    }
                    $arr_rec_qid = json_decode(json_encode($rec_qid), true);
                }
                if(!empty($arr_rec_qid)) break;
            }
        }else{
            $tmp_end_sum = $end_sum-1;
            recdif($tmp_end_sum);
            if(!empty($arr_clid)){
                $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$rec_dif,'is_public'=>'1'])->orWhere(function($query)use($admin_id,$rec_sid,$rec_dif){
                    $query->where('admin_id',$admin_id)
                          ->where('is_public','0')
                          ->where('section_id',$rec_sid)
                          ->where('difficulty',$rec_dif);
                })->pluck('id');
            }else{
                $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$rec_dif,'is_public'=>'1'])->pluck('id');
            }
            $arr_rec_qid = json_decode(json_encode($rec_qid), true);
            $tmp_rec_dif = $rec_dif;
            while(empty($arr_rec_qid)){
                $tmp_rec_dif--;
                if($tmp_rec_dif==0){
                    $jump_sid=1;
                    break;
                } 
                if(!empty($arr_clid)){
                    $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$tmp_rec_dif,'is_public'=>'1'])->orWhere(function($query)use($admin_id,$rec_sid,$tmp_rec_dif){
                        $query->where('admin_id',$admin_id)
                              ->where('is_public','0')
                              ->where('section_id',$rec_sid)
                              ->where('difficulty',$tmp_rec_dif);
                    })->pluck('id');
                }else{
                    $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$tmp_rec_dif,'is_public'=>'1'])->pluck('id');
                } 
                $arr_rec_qid = json_decode(json_encode($rec_qid), true);
            }
            while($jump_sid==1){
                $end_sum=$all_avg;
                recdif($end_sum);
                $rec_sid--;
                if(!empty($arr_clid)){
                    $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$rec_dif,'is_public'=>'1'])->orWhere(function($query)use($admin_id,$rec_sid,$rec_dif){
                        $query->where('admin_id',$admin_id)
                              ->where('is_public','0')
                              ->where('section_id',$rec_sid)
                              ->where('difficulty',$rec_dif);
                    })->pluck('id');
                }else{
                    $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$rec_dif,'is_public'=>'1'])->pluck('id');
                }
                $arr_rec_qid = json_decode(json_encode($rec_qid), true);
                $j_tmp_rec_dif=$rec_dif;
                while(empty($arr_rec_qid)){
                    $j_tmp_rec_dif++;
                    if($j_tmp_rec_dif==4){
                        $jump_sid=1;
                        break;
                    } 
                    if(!empty($arr_clid)){
                        $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$j_tmp_rec_dif,'is_public'=>'1'])->orWhere(function($query)use($admin_id,$rec_sid,$j_tmp_rec_dif){
                            $query->where('admin_id',$admin_id)
                                  ->where('is_public','0')
                                  ->where('section_id',$rec_sid)
                                  ->where('difficulty',$j_tmp_rec_dif);
                        })->pluck('id');
                    }else{
                        $rec_qid = Question::where(['section_id'=>$rec_sid,'difficulty'=>$j_tmp_rec_dif,'is_public'=>'1'])->pluck('id');
                    }
                    $arr_rec_qid = json_decode(json_encode($rec_qid), true);
                }
                if(!empty($arr_rec_qid)) break;
            }
        }
        $recqid_key = array_rand($arr_rec_qid,1);
        $end_rec_qid = $arr_rec_qid[$recqid_key];
        $recqid_adminid = Question::where('id',$end_rec_qid)->pluck('admin_id');
        $recqid_adminname = Admin::where('id',$recqid_adminid)->pluck('name')->last();
        return response()->json([
            'ad'=>$recqid_adminid,
            'adn'=>$recqid_adminname,
            'csid'=>$csid,
            'qstatus'=>$qstatus,
            'ac_qid' => $ac_qid,
            'ac_sid' => $ac_sid,
            'ac_dif' => $ac_dif,
            'csid_ac_qid'=>$csid_ac_qid,
            'end_sum'=>$end_sum,
            'rec_dif'=>$rec_dif,
            'rec_qid'=>$rec_qid,
            'end_rec_qid'=>$end_rec_qid,
        ]);
    }
    public function getOldCode($id){
        $code_record = Record::find($id);
        $code = File::get(storage_path("app/".$code_record->user_id."/".$code_record->location));
        return $code;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Compiler  $compiler
     * @return \Illuminate\Http\Response
     */
    public function edit(Compiler $compiler)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Compiler  $compiler
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Compiler $compiler)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Compiler  $compiler
     * @return \Illuminate\Http\Response
     */
    public function destroy(Compiler $compiler)
    {
        //
    }
}
