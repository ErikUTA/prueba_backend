<?php

namespace App\Models;

use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'description',
        'status',
        'project_id'
    ];

    public function users()
	{
		return $this->belongsToMany(User::class)->withTimestamps();
	}

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
