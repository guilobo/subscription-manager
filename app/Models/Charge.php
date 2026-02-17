<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Charge extends Model
{
    protected $table = 'charges';

    protected $fillable = [
        'user_id',
        'contract_id',
        'client_id',
        'contract_client_id',
        'status_id',
        'user_payment_gateway_id',
        'amount',
        'currency',
        'period_start',
        'period_end',
        'issued_at',
        'due_at',
        'paid_at',
        'gateway_charge_id',
        'gateway_status_raw',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'contract_id' => 'integer',
        'client_id' => 'integer',
        'contract_client_id' => 'integer',
        'status_id' => 'integer',
        'user_payment_gateway_id' => 'integer',
        'amount' => 'decimal:2',
        'period_start' => 'date',
        'period_end' => 'date',
        'issued_at' => 'datetime',
        'due_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(ContractClient::class, 'contract_client_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function gateway(): BelongsTo
    {
        return $this->belongsTo(UserPaymentGateway::class, 'user_payment_gateway_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'charge_id');
    }
}
