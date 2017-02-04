<?php

namespace App;

use App\Repositories\Traits\RecordsActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Comment extends Model
{
    use RecordsActivity,SoftDeletes;

    protected $dates = ['deleted_at','created_at'];


    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function activities()
    {

        return $this->hasMany(Activity::class);
    }


    public function commentable()
    {
        return $this->morphTo();
    }

    public function comments()
    {
        return $this->morphMany(self::class, 'commentable')->with('user');
    }
    public function article()
    {
        return $this->belongsTo(Article::class,'parent_id');

    }
    /*public function parent()
    {
        return $this->belongsTo(self::class,'parent_id');
    }
    public function children()
    {
        return $this->hasMany(self::class,'parent_id')->with('user');
    }*/

    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->diffForHumans();
    }

}
