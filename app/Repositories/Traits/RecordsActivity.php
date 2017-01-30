<?php

namespace App\Repositories\Traits;
use App\Activity;


trait RecordsActivity
{
    /**
     * Register the necessary event listeners.
     *
     * @return void
     */

    public static function bootRecordsActivity()
    {
        foreach (static::getModelEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

    }
    /**
     * Record activity for the model.
     *
     * @param  string $event
     * @return void
     */
    public function recordActivity($event)
    {
        Activity::create([
            'user_id'=> isset($this->user_id) ? $this->user_id:$this->id,
            'name' => $this->getActivityName($this, $event),
            'conversation_id'=>$this->id,
            'conversation_type'=>get_class($this)
        ]);

    }
    /**
     * Prepare the appropriate activity name.
     *
     * @param  mixed  $model
     * @param  string $action
     * @return string
     */
    protected function getActivityName($model, $action)
    {
        $name = strtolower((new \ReflectionClass($model))->getShortName());
        return "{$action}_{$name}";
    }
    /**
     * Get the model events to record activity for.
     *
     * @return array
     */
    protected static function getModelEvents()
    {
        if(isset(static::$recordEvents))
        {
            return static::$recordEvents;
        }
        return [
            'created'
        ];
    }
}