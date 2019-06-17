<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title','category_id' , 'body'];

    /**
     * Get the category for the article.
     */
    public function category()
    {
        return $this->hasMany('App\Category');
    }
}
