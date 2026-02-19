<?php

namespace App\View\Components;

use App\Models\Status;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class StatusBadge extends Component
{
    public ?int $statusId;
    public ?string $scope;
    public string $fallback;

    public function __construct(?int $statusId = null, ?string $scope = null, string $fallback = 'Unknown')
    {
        $this->statusId = $statusId;
        $this->scope = $scope;
        $this->fallback = $fallback;
    }

    public function render(): View|Closure|string
    {
        $status = $this->statusId
            ? Cache::remember("status_badge:{$this->statusId}", now()->addMinutes(10), function () {
                return Status::query()->select(['id', 'key', 'label', 'scope'])->find($this->statusId);
            })
            : null;

        $label = $status?->label ?? $this->fallback;
        $key   = $status?->key ?? null;
        $scope = $status?->scope ?? $this->scope;

        // Color mapping (Tailwind/Daisy/Mary-friendly)
        $classes = $this->badgeClasses($scope, $key);

        return view('components.status-badge', [
            'label' => $label,
            'classes' => $classes,
        ]);
    }

    private function badgeClasses(?string $scope, ?string $key): string
    {
        $scope = strtolower($scope ?? '');
        $key   = strtolower($key ?? '');

        return match ("{$scope}.{$key}") {

            // CLIENT
            'client.active'     => 'bg-green-100 text-green-800 ring-1 ring-green-200',
            'client.inactive'   => 'bg-gray-100 text-gray-700 ring-1 ring-gray-200',

            // CONTRACT
            'contract.draft'    => 'bg-slate-100 text-slate-800 ring-1 ring-slate-200',
            'contract.active'   => 'bg-green-100 text-green-800 ring-1 ring-green-200',
            'contract.paused'   => 'bg-indigo-100 text-indigo-800 ring-1 ring-indigo-200',
            'contract.canceled' => 'bg-zinc-100 text-zinc-700 ring-1 ring-zinc-200',

            // SUBSCRIPTION
            'subscription.active'   => 'bg-green-100 text-green-800 ring-1 ring-green-200',
            'subscription.paused'   => 'bg-amber-100 text-amber-800 ring-1 ring-amber-200',
            'subscription.canceled' => 'bg-zinc-100 text-zinc-700 ring-1 ring-zinc-200',

            // CHARGE
            'charge.pending'   => 'bg-yellow-100 text-yellow-800 ring-1 ring-yellow-200',
            'charge.paid'      => 'bg-emerald-100 text-emerald-800 ring-1 ring-emerald-200',
            'charge.overdue'   => 'bg-red-100 text-red-800 ring-1 ring-red-200',
            'charge.failed'    => 'bg-rose-100 text-rose-800 ring-1 ring-rose-200',
            'charge.canceled'  => 'bg-zinc-100 text-zinc-700 ring-1 ring-zinc-200',

            // PAYMENT
            'payment.succeeded' => 'bg-emerald-100 text-emerald-800 ring-1 ring-emerald-200',
            'payment.failed'    => 'bg-red-100 text-red-800 ring-1 ring-red-200',
            'payment.refunded'  => 'bg-blue-100 text-blue-800 ring-1 ring-blue-200',

            // GATEWAY CONNECTION
            'gateway_connection.active'  => 'bg-green-100 text-green-800 ring-1 ring-green-200',
            'gateway_connection.revoked' => 'bg-red-100 text-red-800 ring-1 ring-red-200',

            default => 'bg-gray-100 text-gray-800 ring-1 ring-gray-200',
        };
    }
}
