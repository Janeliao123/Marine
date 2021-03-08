<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course_list;
use App\Record;
use Auth;
class stu {
    public $name;
    public $user_id;
    public $score_ability;
    public $score_diligent;
    public $easy;
    public $middle;
    public $hard;
    public $sum_q;
}
class warrior {
    public $name;
    public $score;
}
class RankController extends Controller
{
    function cmp_2($a, $b){
        return -1*strcmp($a->score_diligent, $b->score_diligent); //照$score_diligent來sort
    }
    function cmp($a, $b){
        return -1*strcmp($a->score_ability, $b->score_ability); //照$score_ability來sort
    }
    public function index()
    {
        $mon = date("m")+0;
        $year = date("y");
        $c_stu = 0;
        $sum = 0;
        $avg = 0;
        $d = 0;
        $m = 0;
        $e = 0;
        $rank_p = 0;
        $rank2_p = 0;
        $nothing = 0;//是否沒有data
        if($mon>=9){         //下學期
          $user = Record::with('question')->with('user')->where('status','AC')->where(function ($query) {
            $query->whereMonth('created_at','>','8')
                ->orWhereMonth('created_at','<', '2');
        })->get()->groupBy('user_id','question_id');
          $c_user = $user->count();
        }elseif($mon<2){              //上學期
          $user = Record::with('question')->with('user')
                      ->where('status','AC')
                      ->where(function ($query) {
                        $query->whereMonth('created_at','>','8')
                            ->orWhereMonth('created_at','<', '2');
                    })
                      ->get()->groupBy('user_id','question_id');
                      $c_user = $user->count();
        }else {
          $user = Record::with('question')->with('user')->where('status','AC')->whereMonth('created_at','>','1')->whereMonth('created_at','<','9')->get()->groupBy('user_id','question_id');
          $c_user = $user->count();
        }
        //算如果$c_user是0筆資料
        if($c_user==0){
          $nothing = 1;
          return view('rank',compact('nothing'));
        }else {
          foreach ($user as $key => $value) { //loop那些有做題的user
            $stu[$key-1] = new stu();
            $stu[$key-1]->score_ability =  0;
            $stu[$key-1]->easy =  0;
            $stu[$key-1]->middle =  0;
            $stu[$key-1]->hard =  0;
            $stu[$key-1]->sum_q = 0;
            foreach ($user[$key] as $key_s => $value_s) { //loop那個user做的題目
              $u_id = $value_s->user_id;
              $stu[$key-1]->score_ability = $stu[$key-1]->score_ability + $value_s->question->difficulty;
              $stu[$key-1]->name =  $value_s->user->name;
              $stu[$key-1]->user_id =  $value_s->user_id;
              if($value_s->question->difficulty == 1){
                $stu[$key-1]->easy =$stu[$key-1]->easy + 1;
              }elseif ($value_s->question->difficulty == 2) {
                $stu[$key-1]->middle =$stu[$key-1]->middle + 1;
              }else {
                $stu[$key-1]->hard =$stu[$key-1]->hard + 1;
              }
            }
            $stu[$key-1]->sum_q = $stu[$key-1]->easy + $stu[$key-1]->middle + $stu[$key-1]->hard;
            $avg = $stu[$key-1]->score_ability / $stu[$key-1]->sum_q;
            $stu[$key-1]->score_ability = round(sqrt($avg*10)*$stu[$key-1]->sum_q,2); //分數轉換
            $rage = strtotime(Record::where('user_id',$u_id)->where('status','AC')->max('created_at'));
            $today = strtotime(date("Y-m-d H:i:s"));
            $rage = ceil(($today-$rage)/86400); //距離上次答題的天數
            if(log($rage,10) <1){
              $stu[$key-1]->score_diligent = $stu[$key-1]->sum_q;//分數轉換
            }else {
              $stu[$key-1]->score_diligent = round($stu[$key-1]->sum_q/ log($rage,10),1);//分數轉換
            }
          }

          if(isset($stu)){
            $c_stu = count($stu); //多少人?
            //能力榜的排序
            $stu_ability = $stu;
            $stu_ability = collect($stu_ability);// sort $stu
            $stu_ability = $stu_ability->sortByDesc('score_ability');
            if($c_stu < 10 && $c_stu > 0){
              foreach ($stu_ability as $key => $value) {
                $warrior_ability[$key] = new warrior();
                $warrior_ability[$key]->name = $value->name;
                $warrior_ability[$key]->score = $value->score_ability;
              }
              // for($i = 1;$i<=$c_stu;$i++){
              //   $warrior_ability[$i] = new warrior();
              //   $warrior_ability[$i]->name = $stu_ability[$i]->name;
              //   $warrior_ability[$i]->score = $stu_ability[$i]->score_ability;
              // }
            }else {
              $i=1;
              foreach ($stu_ability as $key => $value) {
                $warrior_ability[$key] = new warrior();
                $warrior_ability[$key]->name = $value->name;
                $warrior_ability[$key]->score = $value->score_ability;
                if($i>10){
                  break;
                }
                $i=$i+1;
              }
              // for($i = 1;$i<11;$i++){
              //   $warrior_ability[$i] = new warrior();
              //   $warrior_ability[$i]->name = $stu_ability[$i]->name;
              //   $warrior_ability[$i]->score = $stu_ability[$i]->score_ability;
              // }
            }
            //勤奮榜的排序
            $stu_diligent = $stu;
            $stu_diligent = collect($stu_diligent);// sort $stu
            $stu_diligent = $stu_diligent->sortByDesc('score_diligent');
            if($c_stu < 10 && $c_stu > 0){
              foreach ($stu_diligent as $key2 => $value2) {
                $warrior_diligent[$key2] = new warrior();
                $warrior_diligent[$key2]->name = $value2->name;
                $warrior_diligent[$key2]->score = $value2->score_diligent;
              }
              // for($i = 1;$i<=$c_stu;$i++){
              //   $warrior_diligent[$i] = new warrior();
              //   $warrior_diligent[$i]->name = $stu_diligent[$i]->name;
              //   $warrior_diligent[$i]->score = $stu_diligent[$i]->score_diligent;
              // }
            }else {
              $j=1;
              foreach ($stu_diligent as $key2 => $value2) {
                $warrior_diligent[$key2] = new warrior();
                $warrior_diligent[$key2]->name = $value2->name;
                $warrior_diligent[$key2]->score = $value2->score_diligent;
                if($j>10){
                  break;
                }
                $j=$j+1;
              }
              // for($i = 1;$i<11;$i++){
              //   $warrior_diligent[$i] = new warrior();
              //   $warrior_diligent[$i]->name = $stu_diligent[$i]->name;
              //   $warrior_diligent[$i]->score = $stu_diligent[$i]->score_diligent;
              // }
            }
              //登入的人的各項排序
              if(Auth::check()){
                  $u_id = Auth::user()->id;
                  $user_score = $stu_ability->where('user_id',$u_id)->first();
                  if($user_score==null){
                    $flag=0;//不在榜上
                  }else {
                    $bad_ability=$stu_ability->where('score_ability','<',$user_score->score_ability)->count();
                    $bad_diligent=$stu_diligent->where('score_diligent','<',$user_score->score_diligent)->count();
                    $all = count($stu_diligent);
                    $flag=1;
                    if($all == 0){
                      $nothing = 1;
                      $warrior_ability = 0;
                      $warrior_diligent = 0;
                    }else{

                      $rank_p = round($bad_ability/$all*100,2);
                      $rank2_p = round($bad_diligent/$all*100,2);
                    }
                  }


              }
          }else {
            $nothing = 1;
            $warrior_ability = 0;
            $warrior_diligent = 0;
          }
          return view('rank',compact('warrior_ability','warrior_diligent','c_user','nothing','rank_p','rank2_p','flag'));
        }
    }
}
