<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Igd_info extends Model
{
    use HasFactory;
    protected $table = 'igd_info';
    protected  $primaryKey = 'igd_info_id';
    protected $fillable = ['igd_info_id','name','image','cate_igd_id','calorie','carbohydrate','protein','fat','fiber','admin_id','addess','addess_img'];
    
    public function cate_igd(){
        return $this->hasOne(Category_igd::class,'cate_igd_id','cate_igd_id');
    }

    public function iof(){
        return $this->hasMany(Igd_of_food::class,'igd_info_id','igd_info_id');
    }
}
