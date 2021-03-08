<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewReport extends Model
{
  protected $fillable = [
      'title', 'content',
  ];
}
