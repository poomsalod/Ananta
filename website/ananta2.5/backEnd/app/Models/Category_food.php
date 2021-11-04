<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_food extends Model
{
    use HasFactory;
    protected $table = 'category_food';
    protected $primaryKey = 'cate_food_id';
    protected $fillable = ['cate_food_id','name','admin_id'];
}
