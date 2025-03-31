<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'name',
    ];

    const DEVELOPER = 1;
    const PLANNING = 2;
    const TESTER = 3;
    const RH = 4;

    public function users()
    {
        return $this->hasMany(User::class, 'role');
    }
}
