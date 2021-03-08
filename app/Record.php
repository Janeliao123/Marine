<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    //
    protected $table = 'records';
    protected $fillable = ['user_id', 'question_id','section_id' ,'status','location','user_solvedate'];
    public function question()
    {
        return $this->belongsTo('App\Question');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
