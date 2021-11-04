<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_profile extends Model
{
    use HasFactory;
    protected $table = 'admin_profile';
    protected $primaryKey = 'admin_id';
    protected $fillable = ['admin_id','account_id','f_name','l_name','email','image'];

    function account(){
        return $this->hasOne(Account::class,'account_id','account_id');
    }
}
