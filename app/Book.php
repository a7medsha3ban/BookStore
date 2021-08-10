<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;

class Book extends Model
{

//    book belongsToMany categories
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
}
