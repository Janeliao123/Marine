<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course_user_list;
use App\Course_list;
use App\Record;
use App\User;
use Auth;
use DB;
class CourseUserListsController extends Controller
{
  public function index()
  {
      $admin_id = Auth::guard('admin')->user()->id;
      $courses = Course_list::where('admin_id',$admin_id)->orderBy('school_year','desc')->get();
      return view('admin/course_user_lists.index',compact('courses'));
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

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    if(is_numeric($request->school_year)){
      $Course_lists = new Course_list;
      $Course_lists->school_year = $request->school_year;
      $Course_lists->admin_id = $request->admin_id;
      $Course_lists->save();
      return back();
    }else {
      return back()->with('alert','請填寫正確學年度格式 ex:107上學期 => 1071 ')->with('tx','謝謝您的配合');
    }
  }

  /**
   * Display the specified resource.
*
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      $users = Course_user_list::where('course_list_id',$id)->get();
      $count_user = Course_user_list::where('course_list_id',$id)->get()->count();
      $is_register = array(); //學生是否註冊
      $stu_q = array(); //學生答了幾題
      $stu_c_avg = array(); //學生答對率
      $count_h = 0; //答難題的題數
      $count_m = 0; //答中間題的題數
      $count_e = 0; //答簡單題的題數
      $all_q = 0;
      $all_c_q = 0;
      foreach ($users as $key => $value) {
        $this_user = User::where('acct',$value->acct)->first(); //找學號
        if($this_user == null){   //表示此人尚未註冊...
          $is_register[$value->id] = 0;
        }else {
          $is_register[$value->id] = 1;

          /*各個同學的做題數及答對率*/
          $year_a = Course_list::find($id)->school_year;
          $year = substr($year_a,0,3);
          $dl =  substr($year_a,3,1);
          if($dl == 1){
                        $year = (int)$year + 1911;//哪學年度答的題(上學期答的 ex1071是2018年)
                        $stu_q[$value->id] = Record::where('user_id', '=', $this_user->id)//該學生答了幾題
                        ->where('created_at','like',$year.'%')
                        ->where(function ($query) {
                          $query->whereMonth('created_at','>=','9')
                              ->orWhereMonth('created_at','<', '2');
                            })
                        ->get()->groupBy('question_id','user_id')->count();

                        $all_c = Record::where([ //答對幾題
                          'user_id' => $this_user->id,
                          'status' =>'AC'
                        ])->where('created_at','like',$year.'%')
                        ->where(function ($query) {
                          $query->whereMonth('created_at','>=','9')
                              ->orWhereMonth('created_at','<', '2');
                            })
                        ->get()->groupBy('question_id')->count();

                        if($stu_q[$value->id] == 0){
                          $stu_c_avg[$value->id] =  $stu_c_avg[$value->id] = 0 . "%";
                        }else{
                          $stu_c_avg[$value->id] = round( ($all_c / $stu_q[$value->id]),2 )*100 . "%";
                        }
                        $all_q = $all_q + $stu_q[$value->id];//$all_q加上該同學的答題數
                        $all_c_q =  $all_c_q + $all_c;//$all_c_q+該同學答對題數

                        /*此班同學答題難易度比*/
                        $le_record = DB::table('records')
                                ->where('records.user_id',$this_user->id)
                                ->where('records.created_at','like',$year.'%')
                                ->where(function ($query) {
                                  $query->whereMonth('records.created_at','>=','9')
                                      ->orWhereMonth('records.created_at','<', '2');
                                    })
                                ->join('questions','records.question_id','=','questions.id')
                                ->get()->groupBy('question_id','user_id');
                        $c_le = count($le_record);
                        if($le_record==null){

                        }else{
                          foreach ($le_record as $le_key => $le_value) {
                            foreach ($le_value as $le_key2 => $le_value2) {
                              if(isset($le_value2)){
                                if($le_value2->difficulty == 1){
                                  $count_e = $count_e + 1;
                                }elseif ($le_value2->difficulty == 2) {
                                  $count_m = $count_m + 1;
                                }else {
                                  $count_h = $count_h + 1;
                                }
                              }
                              break;//因為只要一筆
                            }
                          }
                        }
          }elseif($dl == 2){
                    $year = (int)$year + 1912;//哪學年度答的題(下學期答的 ex1072是2019年)
                    $stu_q[$value->id] = Record::where('user_id', '=', $this_user->id)//該學生答了幾題
                    ->where('created_at','like',$year.'%')
                    ->whereMonth('created_at','>','1')
                    ->whereMonth('created_at','<','9')
                    ->get()->groupBy('question_id','user_id')->count();

                    $all_c = Record::where([ //答對幾題
                      'user_id' => $this_user->id,
                      'status' =>'AC'
                    ])->where('created_at','like',$year.'%')
                    ->whereMonth('created_at','>','1')
                    ->whereMonth('created_at','<','9')
                    ->get()->groupBy('question_id')->count();

                    if($stu_q[$value->id] == 0){
                      $stu_c_avg[$value->id] =  $stu_c_avg[$value->id] = 0 . "%";
                    }else{
                      $stu_c_avg[$value->id] = round( ($all_c / $stu_q[$value->id]),2 )*100 . "%";
                    }
                    $all_q = $all_q + $stu_q[$value->id];//$all_q加上該同學的答題數
                    $all_c_q =  $all_c_q + $all_c;//$all_c_q+該同學答對題數

                    /*此班同學答題難易度比*/
                    $le_record = DB::table('records')
                            ->where('records.user_id',$this_user->id)
                            ->where('records.created_at','like',$year.'%')
                            ->whereMonth('records.created_at','>','1')
                            ->whereMonth('records.created_at','<','9')
                            ->join('questions','records.question_id','=','questions.id')
                            ->get()->groupBy('question_id','user_id');
                    $c_le = count($le_record);
                    if($le_record==null){

                    }else{
                      foreach ($le_record as $le_key => $le_value) {
                        foreach ($le_value as $le_key2 => $le_value2) {
                          if(isset($le_value2)){
                            if($le_value2->difficulty == 1){
                              $count_e = $count_e + 1;
                            }elseif ($le_value2->difficulty == 2) {
                              $count_m = $count_m + 1;
                            }else {
                              $count_h = $count_h + 1;
                            }
                          }
                          break;//因為只要一筆
                        }
                      }
                    }
          }else {
            //return view('admin/course_user_lists.show',compact('c_users','users','year','id','is_register','stu_q','stu_c_avg','avg_q','avg_c_q','count_h','count_m','count_e'));}
          }
        }
      }
      if($all_q==0||$count_user==0){
        $avg_c_q =0;
        $avg_q = 0;
      }else{
        $avg_c_q = round( ($all_c_q / $all_q),2 )*100 . "%";
        $avg_q = round($all_q / $count_user,0);
      }
      $year= Course_list::find($id)->school_year;
      $c_users = $users->count();


      return view('admin/course_user_lists.show',compact('c_users','users','year','id','is_register','stu_q','stu_c_avg','avg_q','avg_c_q','count_h','count_m','count_e'));}

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
    $deletedusers = Course_user_list::where('course_list_id', $id)->delete();
    Course_list::destroy($id);
    return back();
  }
  public function deleteAllUser($type,$id){
    if ($type == 1) {
      $deletedusers = Course_user_list::where('course_list_id', $id)->delete();
      return back();
    }else {
      $deletedusers = Course_user_list::find($id);
      $deletedusers->delete();
      return back();
    }

  }
}
