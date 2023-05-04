<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// * This class represents the propellers table in the database
class Propeller extends Model
{
    use HasFactory;

    public function rcModels(): BelongsToMany
    {
        return $this->BelongsToMany(Engine::class, "rc_models_has_propellers")->withPivot('quantity');
    }
}
