<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function todo_application()
    {
        return $this->belongsTo(TodoApplication::class);
    }

    public function done_datetimes()
    {
        return $this->hasMany(TodoDoneDatetime::class);
    }
}
