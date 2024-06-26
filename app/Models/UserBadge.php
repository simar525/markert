<?php

namespace App\Models;

use App\Scopes\SortByIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBadge extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new SortByIdScope);
    }

    protected $fillable = [
        'user_id',
        'badge_id',
        'badge_alias',
        'sort_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function badge()
    {
        return $this->belongsTo(Badge::class);
    }
}
