<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{

    protected $fillable = [
        'user_id','name','conversation_id','conversation_type'
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function conversation()
    {
        return $this->morphTo()->with('user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
