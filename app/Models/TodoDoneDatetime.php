<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoDoneDatetime extends Model
{
    use HasFactory;

    protected $dates = ['done_datetime'];
    protected $guarded = [];

    public function todo()
    {
        return $this->belongsTo(Todo::class);
    }
}
