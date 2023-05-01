<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShortUrl extends Model
{
    use HasFactory;

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }

    public function getLastVisitAtribute(): Carbon
    {
        return $this->visits()->latest()->first()->created_at;
    }
}
