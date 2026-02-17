<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RecurrenceUnit extends Model
{
    protected $table = 'recurrence_units';

    protected $fillable = [
        'key',
        'label',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class, 'recurrence_unit_id');
    }
}
