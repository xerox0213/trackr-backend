<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Achievement extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function habit(): BelongsTo
    {
        return $this->belongsTo(Habit::class);
    }
}
