<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contract extends Model
{
    protected $table = 'contracts';

    protected $fillable = [
        'user_id',
        'status_id',
        'user_payment_gateway_id',
        'name',
        'description',
        'default_amount',
        'default_currency',
        'default_due_day',
        'default_due_days_after_issue',
        'recurrence_unit_id',
        'recurrence_interval',
        'first_charge_mode_id',
        'first_charge_date',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'status_id' => 'integer',
        'user_payment_gateway_id' => 'integer',
        'default_amount' => 'decimal:2',
        'default_due_day' => 'integer',
        'default_due_days_after_issue' => 'integer',
        'recurrence_unit_id' => 'integer',
        'recurrence_interval' => 'integer',
        'first_charge_mode_id' => 'integer',
        'first_charge_date' => 'date',
        'starts_at' => 'date',
        'ends_at' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function gateway(): BelongsTo
    {
        return $this->belongsTo(UserPaymentGateway::class, 'user_payment_gateway_id');
    }

    public function recurrenceUnit(): BelongsTo
    {
        return $this->belongsTo(RecurrenceUnit::class, 'recurrence_unit_id');
    }

    public function firstChargeMode(): BelongsTo
    {
        return $this->belongsTo(FirstChargeMode::class, 'first_charge_mode_id');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(ContractClient::class, 'contract_id');
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(
            Client::class,
            'contract_clients',
            'contract_id',
            'client_id'
        )->withTimestamps();
    }

    public function charges(): HasMany
    {
        return $this->hasMany(Charge::class, 'contract_id');
    }
}
