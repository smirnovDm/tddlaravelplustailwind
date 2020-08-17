<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use DateTimeInterface;

class Project extends Model
{
    protected $guarded = [];

    public $old = [];

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * @return string
     */
    public function path()
    {
        return "/projects/{$this->id}";
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param $body
     * @return mixed
     */
    public function addTask($body)
    {
        return $this->tasks()->create(compact('body'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }

    /**
     * @param $description
     */
    public function recordActivity($description)
    {
        $this->activity()->create([
            'description' => $description,
            'changes'     => $this->activityChanges($description),
        ]);
    }

    /**
     * @return array|void
     */
    protected function activityChanges($description)
    {
        if($description === 'updated') {
            return [
                'before' => Arr::except((array_diff($this->old, $this->getAttributes())), 'updated_at'),
                'after'  => Arr::except($this->getChanges(), 'updated_at'),
            ];
        }
    }
}
