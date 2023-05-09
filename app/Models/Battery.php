<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// * This class represents the batteries table in the database
class Battery extends Model
{
    use HasFactory;

    // * The attributes that are mass assignable.
    protected $fillable = [
        'capacity',
        'cells',
        'type',
        'cRate',
        'user_id',
    ];

    public function rcModels(): BelongsToMany
    {
        return $this->BelongsToMany(RcModel::class, "rc_models_has_batteries")->withPivot('quantity');
    }
}
