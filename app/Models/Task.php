<?php

namespace App\Models;

use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'name',
        'title',
        'description',
        'status',
    ];

    public function users()
	{
		return $this->belongsToMany(User::class, 'task_user')
            ->withPivot('task_id', 'id');
	}

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
