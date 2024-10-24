<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 *
 * @property int $id
 * @property string $title
 * @property int $goal
 * @property string $creation_date
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Achievement> $achievements
 * @property-read int|null $achievements_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Habit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Habit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Habit query()
 * @method static \Illuminate\Database\Eloquent\Builder|Habit whereCreationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Habit whereGoal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Habit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Habit whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Habit whereUserId($value)
 * @mixin \Eloquent
 */
class Habit extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'goal',
        'creation_date'
    ];

    public $timestamps = false;

    public function achievements(): HasMany
    {
        return $this->hasMany(Achievement::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
