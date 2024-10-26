<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecordUpdateTracker extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
