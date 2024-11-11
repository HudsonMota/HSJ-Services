<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function getCategories()
    {
        $categories = Category::all();
        return $categories;
    }

    public function expenses()
    {
        return $this->belongsToMany(Expense::class);
    }
}
