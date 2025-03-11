<?php

namespace App\Models;

use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';

    protected $fillable = [
        'name',
        'description',
        'status',
        'user_id'
    ];

    public function users()
	{
		return $this->belongsToMany(User::class);
	}

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
