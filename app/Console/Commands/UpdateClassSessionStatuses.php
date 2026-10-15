<?php

namespace App\Console\Commands;

use App\Models\ClassSession;
use Illuminate\Console\Command;

class UpdateClassSessionStatuses extends Command
{
    protected $signature = 'sessions:update-statuses';

    protected $description = 'Mark past upcoming class sessions as completed';

    public function handle(): int
    {
        $updated = ClassSession::query()
            ->where('status', 'Upcoming')
            ->whereDate('session_date', '<', today())
            ->update([
                'status' => 'Completed',
            ]);

        $this->info("Updated {$updated} class session(s) to Completed.");

        return self::SUCCESS;
    }
}
