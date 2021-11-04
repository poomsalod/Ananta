<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stock_igd extends Model
{
    use HasFactory;
    protected $table = 'stock_igd';
    protected  $primaryKey = 'stock_igd_id';
    protected $fillable = ['stock_igd_id','user_id','igd_info_id','value','unit'];

    public function igd_info(){
        return $this->hasOne(Igd_info::class,'igd_info_id','igd_info_id');
    }
}
