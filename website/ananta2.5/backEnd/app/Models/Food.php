<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;
    protected  $primaryKey = 'food_id';
    protected $fillable = ['food_id','name','image','cate_food_id','calorie','carbohydrate','protein','fat','fiber','status','addess','admin_id'];

    public function cate_food(){
        return $this->hasOne(Category_food::class,'cate_food_id','cate_food_id');
    }

    public function iof(){
        return $this->hasMany(Igd_of_food::class,'food_id','food_id');
    }

    public function step(){
        return $this->hasMany(Step_of_food::class,'food_id','food_id');
    }
}
