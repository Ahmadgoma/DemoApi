<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    /**
     * Get the articles for the category.
     */
    public function articles()
    {
        return $this->hasMany('App\Article');
    }

    // this is a recommended way to declare event handlers
    public static function boot() {
        parent::boot();

        static::deleting(function($category) { // before delete() method call this
            $category->articles()->delete();
            // do the rest of the cleanup...
        });
    }

}
