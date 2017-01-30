<?php

namespace App;

use App\Repositories\Traits\RecordsActivity;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable,RecordsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','avatar','is_active','confirmation_token','password','github_id','github_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function article()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);

    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function followers() //被关注
    {
        return $this->belongsToMany(self::class,'followers', 'follow_id', 'user_id')->withTimestamps();
    }

    public function followings() //关注
    {
        return $this->belongsToMany(self::class, 'followers', 'user_id', 'follow_id')->withTimestamps();
    }

    public function user()
    {
        return $this->hasMany(self::class,'id');
    }




}
