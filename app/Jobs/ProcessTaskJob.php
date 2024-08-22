<?php

namespace App\Jobs;

use App\Enums\TaskPriority;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProcessTaskJob implements ShouldQueue
{
    use Queueable;
    public $maxExceptions  = 2 ;
    public $tries=3;
    /**
     * Create a new job instance.
     */
    public function __construct(public string $priority='medium')
    {
        $this->onQueue($this->priority);
        $this->onConnection('redis');
    }

    public function failed(Throwable $exception)
    {
        Log::info('Something goes wrong');
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('job done on '.$this->priority . ' priority');
    }
}
