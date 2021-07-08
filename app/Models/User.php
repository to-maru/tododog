<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public function todo_application()
    {
        return $this->hasOne(TodoApplication::class, 'id');
    }

    public function user_setting_analysis()
    {
        return $this->hasOne(UserSettingAnalysis::class, 'id');
    }

    public function user_setting_notification()
    {
        return $this->hasOne(UserSettingNotification::class,'id');
    }

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($user) {
            $user->todo_application()->delete();
            $user->user_setting_analysis()->delete();
            $user->user_setting_notification()->delete();
        });
    }
}
