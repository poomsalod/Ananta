<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food_allergy extends Model
{
    use HasFactory;
    protected $table = 'food_allergy';
    protected  $primaryKey = 'food_allergy_id';
    protected $fillable = ['food_allergy_id','user_id','igd_info_id'];

    public function igd_info(){
        return $this->hasOne(Igd_info::class,'igd_info_id','igd_info_id');
    }
}
