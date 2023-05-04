<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// * This class represents the flights table in the database
class Flights extends Model
{
    use HasFactory;

    public function rcModel(): BelongsTo
    {
        return $this->belongsTo(RcModel::class);
    }
}
