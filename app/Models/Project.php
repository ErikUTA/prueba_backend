<?php

namespace App\Models;

use App\Models\User;
use App\Models\Task;
use App\Models\ProjectStatus;
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
		return $this->belongsToMany(User::class)->withTimestamps();
	}

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function projectStatus()
    {
        return $this->belongsTo(ProjectStatus::class);
    }
}
