<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food_rating extends Model
{
    use HasFactory;
    protected $table = 'food_rating';
    protected $primaryKey = 'food_rating_id';
    protected $fillable = ['food_rating_id','user_id','food_id','rating_score'];

    public function food(){
        return $this->hasOne(Food::class,'food_id','food_id'); 
    }
    
}
