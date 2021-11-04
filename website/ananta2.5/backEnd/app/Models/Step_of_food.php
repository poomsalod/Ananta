<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step_of_food extends Model
{
    use HasFactory;
    protected $table = 'step_of_food';
    protected $primaryKey = 'step_of_food_id';
    protected $fillable = ['step_of_food_id','food_id','order','step','admin_id'];

    public function food(){
        return $this->hasOne(Food::class,'food_id','food_id');
    }
}
