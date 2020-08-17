<?php


namespace App;


trait TriggerActivity
{
    /**
     * hz
     */
    protected static function bootRecordActivity()
    {
        foreach (static::getModelEventsToRecord() as $event)
        {
            static::$event(function ($model) use ($event){
                $model->recordActivity(
                    $model->formatActivityDescription($event)
                );
            });
        }
    }

    /**
     * @param $description
     */
    public function recordActivity($description)
    {
        $this
            ->activitySubjuct()
            ->activity()
            ->create('description');
    }

    /**
     * @return mixed
     */
    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * @return $this
     */
    protected function activitySubject()
    {
        return $this;
    }

    /**
     * @return string[]
     */
    protected static function getModelEventsToRecord()
    {
        if(isset(static::$modelEventsToRecord)){
            return static::$modelEventsToRecord;
        }

        return ['created', 'updated', 'deleted'];
    }

    /**
     * @param $event
     * @return string
     */
    protected function formatActivityDescription($event)
    {
        return "{$event}_" . strtolower(class_basename($this));
    }

}
