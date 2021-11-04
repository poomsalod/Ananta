<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_igd extends Model
{
    use HasFactory;
    protected $table = 'category_igd';
    protected  $primaryKey = 'cate_igd_id';
    protected $fillable = ['cate_igd_id','name','admin_id'];
}
