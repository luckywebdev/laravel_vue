<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    protected $table = 'departments';
    protected $fillable = ['id','name','description'];
    public $timestamps = false;

}
