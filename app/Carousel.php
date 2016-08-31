<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{	
	public static $rules = [
     'title' => 'required|max:75',
     'desc' => 'required|filled',
     'img' => 'required|image',
     'url' => 'required|url'
   	];
    //
}

