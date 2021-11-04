<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eating_history extends Model
{
    use HasFactory;
    protected $table = 'eating_history';
    protected $primaryKey = 'eating_history_id';
    protected $fillable = ['eating_history_id','user_id','food_id'];
}
