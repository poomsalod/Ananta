<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food_recommended extends Model
{
    use HasFactory;
    protected $table = 'food_recommended';
    protected $primaryKey = 'food_recommended_id';
    protected $fillable = ['food_recommended_id','user_id','food_id','score_nutrition','score_sum','igd_matching'];
}
