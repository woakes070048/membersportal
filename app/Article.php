<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
	use SoftDeletes;

	protected $dates = [
		'date'
	];

	public static $rules = [
		'heading' => 'required|max:250',
		'subheading' => 'max:250',
		'desc' => 'required|max:500',
		'img' => 'image|required',
		'url' => 'required|url'
	];

	public function getHeadingAttribute($value)
	{
		return ucwords($value);
	}

	public function getSubheadingAttribute($value)
	{
		return ucwords($value);
	}

	public static function homeArticles()
	{
		$articles = Article::orderBy('date', 'desc')->take(5)->get();
		return $articles;
	}
}
