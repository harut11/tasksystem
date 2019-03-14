<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class tasks extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'status', 'deadline', 'manager_id', 'developer_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function developers(){
        return $this->belongsToMany(User::class)
            ->withPivot('assignpivot', 'user_id');
    }
}
