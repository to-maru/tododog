<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $dates = ['origin_created_at'];
    protected $guarded = [];

    public function getDueAttribute()
    {
        $raw_data = json_decode($this->raw_data, true);
        return $raw_data['due'] ?? [];
    }

    public function todo_application()
    {
        return $this->belongsTo(TodoApplication::class);
    }

    public function done_datetimes()
    {
        return $this->hasMany(TodoDoneDatetime::class);
    }
}
