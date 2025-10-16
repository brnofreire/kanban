<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'board_id',
        'title',
        'position',
    ];

    /**
     * Get the board that owns the category.
     */
    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    /**
     * Get the tasks for the category.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->orderBy('position');
    }
}
