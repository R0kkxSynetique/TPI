<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Env;

// * This class represents the rc_models table in the database
class RcModel extends Model
{
    use HasFactory;

    // * The attributes that are mass assignable.
    protected $fillable = [
        'name',
        'manufacturer',
        'description',
        'wingSpan',
        'weight',
        'length',
        'height',
        'acquired_on',
        'finished_on',
        'first_flown_on',
        'flights_offset',
        'user_id',
        'transmitter_id'
    ];

    public function engines(): BelongsToMany
    {
        return $this->BelongsToMany(Engine::class, "rc_models_has_engines")->withPivot('quantity');
    }

    public function propellers(): BelongsToMany
    {
        return $this->BelongsToMany(Propeller::class, "rc_models_has_propellers")->withPivot('quantity');
    }

    public function batteries(): BelongsToMany
    {
        return $this->BelongsToMany(Battery::class, "rc_models_has_batteries")->withPivot('quantity');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function transmitter(): BelongsTo
    {
        return $this->belongsTo(Transmitter::class);
    }
}
