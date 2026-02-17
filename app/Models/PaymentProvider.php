<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentProvider extends Model
{
    protected $table = 'payment_providers';

    protected $fillable = [
        'key',
        'name',
        'website',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function userPaymentGateways(): HasMany
    {
        return $this->hasMany(UserPaymentGateway::class, 'payment_provider_id');
    }
}
