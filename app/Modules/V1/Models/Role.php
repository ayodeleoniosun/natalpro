<?php

namespace App\Modules\V1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'role';
    protected $fillable = ['name'];
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_to_user');
    }
}
