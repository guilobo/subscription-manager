<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReferenceDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedStatuses();
        $this->seedRecurrenceUnits();
        $this->seedFirstChargeModes();
        $this->seedPaymentProviders();
    }

    private function seedStatuses(): void
    {
        $statuses = [

            // CLIENT
            ['key' => 'active', 'label' => 'Active', 'scope' => 'client'],
            ['key' => 'inactive', 'label' => 'Inactive', 'scope' => 'client'],

            // CONTRACT
            ['key' => 'draft', 'label' => 'Draft', 'scope' => 'contract'],
            ['key' => 'active', 'label' => 'Active', 'scope' => 'contract'],
            ['key' => 'paused', 'label' => 'Paused', 'scope' => 'contract'],
            ['key' => 'canceled', 'label' => 'Canceled', 'scope' => 'contract'],

            // SUBSCRIPTION (contract_clients)
            ['key' => 'active', 'label' => 'Active', 'scope' => 'subscription'],
            ['key' => 'paused', 'label' => 'Paused', 'scope' => 'subscription'],
            ['key' => 'canceled', 'label' => 'Canceled', 'scope' => 'subscription'],

            // CHARGE
            ['key' => 'pending', 'label' => 'Pending', 'scope' => 'charge'],
            ['key' => 'paid', 'label' => 'Paid', 'scope' => 'charge'],
            ['key' => 'overdue', 'label' => 'Overdue', 'scope' => 'charge'],
            ['key' => 'failed', 'label' => 'Failed', 'scope' => 'charge'],
            ['key' => 'canceled', 'label' => 'Canceled', 'scope' => 'charge'],

            // PAYMENT
            ['key' => 'succeeded', 'label' => 'Succeeded', 'scope' => 'payment'],
            ['key' => 'failed', 'label' => 'Failed', 'scope' => 'payment'],
            ['key' => 'refunded', 'label' => 'Refunded', 'scope' => 'payment'],

            // GATEWAY CONNECTION
            ['key' => 'active', 'label' => 'Active', 'scope' => 'gateway_connection'],
            ['key' => 'revoked', 'label' => 'Revoked', 'scope' => 'gateway_connection'],
        ];

        foreach ($statuses as $status) {
            DB::table('statuses')->updateOrInsert(
                ['key' => $status['key'], 'scope' => $status['scope']],
                $status
            );
        }
    }

    private function seedRecurrenceUnits(): void
    {
        $units = [
            ['key' => 'week', 'label' => 'Weekly'],
            ['key' => 'month', 'label' => 'Monthly'],
            ['key' => 'year', 'label' => 'Yearly'],
        ];

        foreach ($units as $unit) {
            DB::table('recurrence_units')->updateOrInsert(
                ['key' => $unit['key']],
                $unit
            );
        }
    }

    private function seedFirstChargeModes(): void
    {
        $modes = [
            ['key' => 'immediate', 'label' => 'Immediate'],
            ['key' => 'next_period', 'label' => 'Next Period'],
            ['key' => 'fixed_date', 'label' => 'Fixed Date'],
        ];

        foreach ($modes as $mode) {
            DB::table('first_charge_modes')->updateOrInsert(
                ['key' => $mode['key']],
                $mode
            );
        }
    }

    private function seedPaymentProviders(): void
    {
        $providers = [
//            ['key' => 'asaas', 'name' => 'Asaas', 'website' => 'https://asaas.com'],
//            ['key' => 'stripe', 'name' => 'Stripe', 'website' => 'https://stripe.com'],
            ['key' => 'mercadopago', 'name' => 'Mercado Pago', 'website' => 'https://www.mercadopago.com'],
        ];

        foreach ($providers as $provider) {
            DB::table('payment_providers')->updateOrInsert(
                ['key' => $provider['key']],
                $provider
            );
        }
    }
}
