<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Api_history extends Model
{
    use HasFactory;
    protected $fillable = ['name','image','calorie','date','time'];
}
