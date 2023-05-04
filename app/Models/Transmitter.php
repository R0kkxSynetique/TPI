<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// * This class represents the transmitters table in the database
class Transmitter extends Model
{
    use HasFactory;

    public function rcModels(): HasMany
    {
        return $this->hasMany(RcModel::class);
    }
}
