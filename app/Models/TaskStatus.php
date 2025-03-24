<?php

namespace App\Models;

use App\Models\Task;
use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    protected $table = 'task_status';

    protected $fillable = [
        'name',
    ];

    const IN_PROCESS = 1;
    const COMPLETED = 2;
    const IN_TESTING = 3;
    const BUG = 4;
    const AWAITING_ASSIGNMENT = 5;

    public function tasks()
    {
        return $this->hasMany(Task::class, 'status');
    }
}