<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;

class DeleteInactiveTenants extends Command
{
    protected $signature = 'tenants:delete-inactive';
    protected $description = 'Delete inactive tenants with no new data in the past year';

    public function handle()
    {
        // Define the cutoff date (1 year ago)
        $cutoffDate = Carbon::now()->subYear();

        // Get inactive tenants
        $inactiveTenants = Tenant::whereDoesntHave('xpRecords', function ($query) use ($cutoffDate) {
            $query->where('created_at', '>', $cutoffDate);
        })->get();

        // Delete inactive tenants
        foreach ($inactiveTenants as $tenant) {
            $tenant->xpRecords()->delete(); // Delete associated points records
            $tenant->delete();
        }

        $this->info(count($inactiveTenants) . ' inactive tenants deleted successfully.');
    }
}
