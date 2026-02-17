<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Client extends Model
{
    protected $table = 'clients';

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'user_id',
        'status_id',
        'name',
        'email',
        'document',
        'phone',
    ];

    /**
     * Attribute casting.
     */
    protected $casts = [
        'user_id'   => 'integer',
        'status_id' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Owner user (system account).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Status reference (scope = client).
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Pivot records linking contracts to this client.
     */
    public function contractSubscriptions(): HasMany
    {
        return $this->hasMany(ContractClient::class);
    }

    /**
     * Contracts linked to this client (many-to-many).
     */
    public function contracts(): BelongsToMany
    {
        return $this->belongsToMany(
            Contract::class,
            'contract_clients',
            'client_id',
            'contract_id'
        )->withTimestamps();
    }

    /**
     * Charges billed to this client.
     */
    public function charges(): HasMany
    {
        return $this->hasMany(Charge::class);
    }
}
