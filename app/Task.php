<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];
    /**
     * @var string
     */
    protected $table = 'tasks';

    /**
     * @var string[]
     */
    protected $casts = [
        'completed' => 'boolean'
    ];

    /**
     * @var string[]
     */
    protected $touches = ['project'];

    /**
     * Complete the task.
     */
    public function complete()
    {
        $this->update(['completed' => true]);

        $this->project->recordActivity('completed_task');
    }

    /**
     * Incomplete the task.
     */
    public function incomplete()
    {
        $this->update(['completed' => false]);

        $this->project->recordActivity('uncompleted_task');
    }


    /**
     * @return string
     */
    public function path()
    {
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
