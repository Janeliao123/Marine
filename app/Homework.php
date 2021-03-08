<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    protected $fillable = [
        'user_id', 'location','select_questions_id','code_id'
    ];
}
