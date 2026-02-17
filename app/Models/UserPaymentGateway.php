<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserPaymentGateway extends Model
{
    protected $table = 'user_payment_gateways';

    protected $fillable = [
        'user_id',
        'payment_provider_id',
        'status_id',
        'name',
        'is_default',
        'credentials_encrypted',
        'webhook_secret_encrypted',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'payment_provider_id' => 'integer',
        'status_id' => 'integer',
        'is_default' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function paymentProvider(): BelongsTo
    {
        return $this->belongsTo(PaymentProvider::class, 'payment_provider_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class, 'user_payment_gateway_id');
    }

    public function charges(): HasMany
    {
        return $this->hasMany(Charge::class, 'user_payment_gateway_id');
    }
}
