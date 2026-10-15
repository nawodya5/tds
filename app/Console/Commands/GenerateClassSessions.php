<?php

namespace App\Console\Commands;

use App\Services\ClassSessionGeneratorService;
use Illuminate\Console\Command;

class GenerateClassSessions extends Command
{
    protected $signature = 'classes:generate-sessions';

    protected $description = 'Generate class sessions for the next three months';

    public function handle(
        ClassSessionGeneratorService $generator
    ): int {
        $created = $generator->generateForActiveClasses();

        $this->info("Generated {$created} new class sessions.");

        return self::SUCCESS;
    }
}
