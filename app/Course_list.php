<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course_list extends Model
{
  public $timestamps = false;
  public function question()
 {
     return $this->belongsToMany('App\Question','admin_select_questions');
 }
}
