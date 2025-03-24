<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;

class ProjectStatus extends Model
{
    protected $table = 'project_status';
    
    protected $fillable = [
        'name',
    ];

    const DEVELOPMENT = 1;
    const FINISHED = 2;
    const CANCELLED = 3;
    const PAUSE = 4;

    public function projects()
    {
        return $this->hasMany(Project::class, 'status');
    }
}
