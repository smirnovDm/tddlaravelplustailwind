<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var string[]
     */
    protected $casts = [
        'changes' => 'array'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subject()
    {
        return $this->morphTo();
    }
}
