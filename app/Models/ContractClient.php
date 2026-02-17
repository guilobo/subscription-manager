<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContractClient extends Model
{
    protected $table = 'contract_clients';

    protected $fillable = [
        'contract_id',
        'client_id',
        'status_id',
        'custom_amount',
        'custom_currency',
        'custom_due_day',
        'custom_due_days_after_issue',
        'first_charge_mode_id',
        'first_charge_date',
        'starts_at',
        'ends_at',
        'next_charge_at',
    ];

    protected $casts = [
        'contract_id' => 'integer',
        'client_id' => 'integer',
        'status_id' => 'integer',
        'custom_amount' => 'decimal:2',
        'custom_due_day' => 'integer',
        'custom_due_days_after_issue' => 'integer',
        'first_charge_mode_id' => 'integer',
        'first_charge_date' => 'date',
        'starts_at' => 'date',
        'ends_at' => 'date',
        'next_charge_at' => 'datetime',
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function firstChargeMode(): BelongsTo
    {
        return $this->belongsTo(FirstChargeMode::class, 'first_charge_mode_id');
    }

    public function charges(): HasMany
    {
        return $this->hasMany(Charge::class, 'contract_client_id');
    }
}
