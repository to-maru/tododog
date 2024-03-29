<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoApplication extends Model
{
    use HasFactory;

    protected $dates = ['synced_at', 'origin_created_at'];
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function todos()
    {
        return $this->hasMany(Todo::class);
    }
}
