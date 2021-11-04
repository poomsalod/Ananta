<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Igd_of_food extends Model
{
    use HasFactory;
    protected $table = 'igd_of_food';
    protected $primaryKey = 'igd_of_food_id';
    protected $fillable = ['igd_of_food_id','food_id','igd_info_id','description','value','unit','importance','admin_id'];

    public function food(){
        return $this->hasOne(Food::class,'food_id','food_id');
    }

    public function igd_info(){
        return $this->hasOne(Igd_info::class,'igd_info_id','igd_info_id');
    }
}
