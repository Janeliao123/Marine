<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course_user_list;
use App\Course_list;
use App\Record;
use App\User;
use Auth;
use DB;
class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin_id = Auth::guard('admin')->user()->id;
        $last_year = Course_list::where('admin_id', $admin_id)->max('school_year');
        $course_id = Course_list::where('school_year', $last_year)->where('admin_id', $admin_id)->max('id');
        $is_set = 1;
        if( $last_year == null ){
          $user_lists = '尚未建立學生資料';
          $is_set = 0; //判斷是否建立學生資料
        }else{
          $users = Course_user_list::where('course_list_id',$course_id)->get();
          $count_user = Course_user_list::where('course_list_id',$course_id)->get()->count();
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
              $year_a = Course_list::find($course_id)->school_year;
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
          $year= Course_list::find($course_id)->school_year;
          $c_users = $users->count();
        }

        return view('admin.index',compact('user_lists','last_year','is_set','c_users','users','year','course_id','is_register','stu_q','stu_c_avg','avg_q','avg_c_q','count_h','count_m','count_e'));
    }
}
