<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// * This class represents the engines table in the database
class Engine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'power',
        'frequency',
        'type',
        'weight',
        'fuel',
        'user_id'
    ];

    public function rcModel(): BelongsToMany
    {
        return $this->belongsToMany(RcModel::class, "rc_models_has_engines")->withPivot('quantity');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
