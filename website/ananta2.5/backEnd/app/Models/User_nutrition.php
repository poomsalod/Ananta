<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_nutrition extends Model
{
    use HasFactory;
    protected $table = 'user_nutrition';
    protected $primaryKey = 'user_nutrition_id';
    protected $fillable = ['user_nutrition_id','user_id','gender','age','weight','height','activity','bmr','bmi','tdee','analyze_bmi'];
}
