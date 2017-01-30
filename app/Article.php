<?php

namespace App;

use App\Repositories\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use RecordsActivity,SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'title', 'content','last_user_id','user_id','images'
    ];
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function like()
    {
        return $this->belongsToMany(User::class)->withTimestamps();;
    }
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
