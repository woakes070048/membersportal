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

    public function getDescAttribute($value)
    {
        return ucwords($value);
    }

    public function getTitleAttribute($value)
    {
        return ucwords($value);
    }

    public static function pullCarousels()
    {
    	$carousels = Carousel::orderBy('created_at', 'desc')->take(2)->get();
    	return $carousels;
    }
}
