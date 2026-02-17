<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    protected $table = 'statuses';

    protected $fillable = [
        'key',
        'label',
        'scope',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class, 'status_id');
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class, 'status_id');
    }

    public function contractClients(): HasMany
    {
        return $this->hasMany(ContractClient::class, 'status_id');
    }

    public function charges(): HasMany
    {
        return $this->hasMany(Charge::class, 'status_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'status_id');
    }

    public function userPaymentGateways(): HasMany
    {
        return $this->hasMany(UserPaymentGateway::class, 'status_id');
    }
}
