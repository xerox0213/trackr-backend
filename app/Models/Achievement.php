<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 *
 *
 * @property int $id
 * @property string $achievement_date
 * @property int $habit_id
 * @property-read \App\Models\Habit $habit
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement whereAchievementDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement whereHabitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement whereId($value)
 * @mixin \Eloquent
 */
class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'achievement_date'
    ];

    public $timestamps = false;

    public function habit(): BelongsTo
    {
        return $this->belongsTo(Habit::class);
    }
}
