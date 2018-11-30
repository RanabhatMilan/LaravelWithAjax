<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class info extends Model
{
    protected $fillable = ['first_name','last_name','email','age','gender','user_image'];
}
