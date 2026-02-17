<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FirstChargeMode extends Model
{
    protected $table = 'first_charge_modes';

    protected $fillable = [
        'key',
        'label',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class, 'first_charge_mode_id');
    }

    public function contractClients(): HasMany
    {
        return $this->hasMany(ContractClient::class, 'first_charge_mode_id');
    }
}
